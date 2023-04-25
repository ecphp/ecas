<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas;

use EcPhp\CasLib\Contract\CasInterface;
use EcPhp\CasLib\Contract\Configuration\PropertiesInterface;
use EcPhp\CasLib\Contract\Response\CasResponseBuilderInterface;
use EcPhp\CasLib\Exception\CasException;
use EcPhp\Ecas\Handler\LoginTransaction;
use EcPhp\Ecas\Handler\ProxyCallback;
use EcPhp\Ecas\Handler\RequestTicketValidation;
use EcPhp\Ecas\Service\Parameters;
use loophp\psr17\Psr17Interface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

final class Ecas implements CasInterface
{
    public function __construct(
        private readonly CasInterface $cas,
        private readonly PropertiesInterface $properties,
        private readonly Psr17Interface $psr17,
        private readonly CasResponseBuilderInterface $casResponseBuilder,
        private readonly ClientInterface $client,
    ) {
    }

    public function authenticate(
        ServerRequestInterface $request,
        array $parameters = []
    ): array {
        try {
            $response = $this->requestTicketValidation($request, $parameters);
        } catch (Throwable $exception) {
            throw CasException::unableToAuthenticate($exception);
        }

        try {
            $casResponse = $this
                ->casResponseBuilder
                ->fromResponse($response);
        } catch (Throwable $exception) {
            throw CasException::unableToAuthenticate($exception);
        }

        try {
            $credentials = $casResponse->toArray();
        } catch (Throwable $exception) {
            throw CasException::unableToAuthenticate($exception);
        }

        return $credentials;
    }

    public function handleProxyCallback(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        return $this
            ->process(
                $request->withAttribute('parameters', $parameters),
                new ProxyCallback($this->cas, $this->psr17)
            );
    }

    public function login(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        // To properly implement the decorator pattern, we cannot simply call
        // $this->cas->method(). This bypasses the $this->process() and does not
        // adhere to the pattern.
        // To address this, an anonymous RequestHandler class is used when the
        // method is not overridden, or a regular class in a separate file when
        // it is overridden.
        $handler = new class($this->cas) implements RequestHandlerInterface {
            public function __construct(
                private readonly CasInterface $cas
            ) {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this
                    ->cas
                    ->login(
                        $request,
                        $request->getAttribute('parameters', [])
                    );
            }
        };

        $response = $this->process(
            $request->withAttribute('parameters', $parameters),
            $handler
        );

        // Do the LoginTransaction feature stuff.
        return $this->process(
            $request->withAttribute('response', $response),
            new LoginTransaction(
                $this->cas,
                $this->psr17,
                $this->casResponseBuilder,
                $this->client,
            )
        );
    }

    public function logout(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        // To properly implement the decorator pattern, we cannot simply call
        // $this->cas->method(). This bypasses the $this->process() and does not
        // adhere to the pattern.
        // To address this, an anonymous RequestHandler class is used when the
        // method is not overridden, or a regular class in a separate file when
        // it is overridden.
        $handler = new class($this->cas) implements RequestHandlerInterface {
            public function __construct(
                private readonly CasInterface $cas,
            ) {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this
                    ->cas
                    ->logout(
                        $request,
                        $request->getAttribute('parameters', [])
                    );
            }
        };

        return $this->process(
            $request->withAttribute('parameters', $parameters),
            $handler
        );
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return $this->cas->process($request, $handler);
    }

    public function requestProxyTicket(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        // To properly implement the decorator pattern, we cannot simply call
        // $this->cas->method(). This bypasses the $this->process() and does not
        // adhere to the pattern.
        // To address this, an anonymous RequestHandler class is used when the
        // method is not overridden, or a regular class in a separate file when
        // it is overridden.
        $handler = new class($this->cas) implements RequestHandlerInterface {
            public function __construct(
                private readonly CasInterface $cas
            ) {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this
                    ->cas
                    ->requestProxyTicket(
                        $request,
                        $request->getAttribute('parameters', [])
                    );
            }
        };

        return $this->process(
            $request->withAttribute('parameters', $parameters),
            $handler
        );
    }

    public function requestServiceValidate(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        // To properly implement the decorator pattern, we cannot simply call
        // $this->cas->method(). This bypasses the $this->process() and does not
        // adhere to the pattern.
        // To address this, an anonymous RequestHandler class is used when the
        // method is not overridden, or a regular class in a separate file when
        // it is overridden.
        $handler = new class($this->cas) implements RequestHandlerInterface {
            public function __construct(
                private readonly CasInterface $cas
            ) {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this
                    ->cas
                    ->requestServiceValidate(
                        $request,
                        $request->getAttribute('parameters', [])
                    );
            }
        };

        return $this->process(
            $request->withAttribute('parameters', $parameters),
            $handler
        );
    }

    public function requestTicketValidation(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        return $this
            ->process(
                $request->withAttribute('parameters', $parameters),
                new RequestTicketValidation(
                    $this->cas,
                    $this->psr17,
                    $this->properties,
                )
            );
    }

    public function supportAuthentication(
        ServerRequestInterface $request,
        array $parameters = []
    ): bool {
        return $this
            ->cas
            ->supportAuthentication(
                $request,
                (new Parameters())->addTicketFromRequestHeaders(
                    $request->withAttribute('parameters', $parameters)
                )
            );
    }
}
