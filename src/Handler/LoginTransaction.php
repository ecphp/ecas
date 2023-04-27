<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Handler;

use EcPhp\CasLib\Contract\CasInterface;
use EcPhp\CasLib\Contract\Response\CasResponseBuilderInterface;
use EcPhp\CasLib\Exception\CasHandlerException;
use EcPhp\Ecas\Contract\Response\Type\LoginRequest;
use EcPhp\Ecas\Exception\EcasHandlerException;
use Ergebnis\Http\Method;
use loophp\psr17\Psr17Interface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

final class LoginTransaction implements RequestHandlerInterface
{
    public function __construct(
        private readonly CasInterface $cas,
        private readonly Psr17Interface $psr17,
        private readonly CasResponseBuilderInterface $casResponseBuilder,
        private readonly ClientInterface $client,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $request->getAttribute('response');

        if (!$response instanceof ResponseInterface) {
            throw EcasHandlerException::badResponseAttribute();
        }

        $uri = $this
            ->psr17
            ->createUri(
                $response->getHeaderLine('Location')
            );

        $parameters = [
            'loginRequestId' => $this->getTransactionId($uri),
        ];

        return $this
            ->psr17
            ->createResponse(302)
            ->withHeader(
                'Location',
                (string) $uri
                    ->withQuery(http_build_query($parameters))
            );
    }

    private function getTransactionId(UriInterface $uri): string
    {
        $loginRequestUri = $uri
            ->withPath(sprintf('%s/%s', $uri->getPath(), 'init'))
            ->withQuery('');

        $postRequest = $this
            ->psr17
            ->createRequest(
                Method::POST,
                $loginRequestUri
            )
            ->withBody(
                $this->psr17->createStream($uri->getQuery())
            );

        try {
            $response = $this
                ->client
                ->sendRequest($postRequest);
        } catch (Throwable $exception) {
            throw CasHandlerException::errorWhileDoingRequest($exception);
        }

        $response = $this
            ->casResponseBuilder
            ->fromResponse($response);

        if (!$response instanceof LoginRequest) {
            throw EcasHandlerException::loginRequestFailure($response);
        }

        return $response->getTransactionId();
    }
}
