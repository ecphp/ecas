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
use loophp\psr17\Psr17Interface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ProxyCallback implements RequestHandlerInterface
{
    public function __construct(
        private readonly CasInterface $cas,
        private readonly Psr17Interface $psr17,
        private readonly array $parameters
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = '<?xml version="1.0" encoding="utf-8"?><proxySuccess xmlns="http://www.yale.edu/tp/casClient" />';

        return $this
            ->cas
            ->handleProxyCallback($request, $this->parameters)
            ->withBody(
                $this
                    ->psr17
                    ->createStream($body)
            );
    }
}
