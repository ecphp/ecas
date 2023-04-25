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
use EcPhp\Ecas\Handler\ProxyCallback;
use EcPhp\Ecas\Handler\RequestTicketValidation;
use EcPhp\Ecas\Service\Parameters;
use loophp\psr17\Psr17Interface;
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
        private readonly CasResponseBuilderInterface $casResponseBuilder
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
                $request,
                new ProxyCallback($this->cas, $this->psr17, $parameters)
            );
    }

    public function login(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        $handler = new class($this->cas, $parameters) implements RequestHandlerInterface {
            public function __construct(
                private readonly CasInterface $cas,
                private readonly array $parameters
            ) {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this->cas->login($request, $this->parameters);
            }
        };

        return $this->process($request, $handler);
    }

    public function logout(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        $handler = new class($this->cas, $parameters) implements RequestHandlerInterface {
            public function __construct(
                private readonly CasInterface $cas,
                private readonly array $parameters
            ) {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this->cas->logout($request, $this->parameters);
            }
        };

        return $this->process($request, $handler);
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
        $handler = new class($this->cas, $parameters) implements RequestHandlerInterface {
            public function __construct(
                private readonly CasInterface $cas,
                private readonly array $parameters
            ) {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this->cas->requestProxyTicket($request, $this->parameters);
            }
        };

        return $this->process($request, $handler);
    }

    public function requestServiceValidate(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        $handler = new class($this->cas, $parameters) implements RequestHandlerInterface {
            public function __construct(
                private readonly CasInterface $cas,
                private readonly array $parameters
            ) {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this->cas->requestServiceValidate($request, $this->parameters);
            }
        };

        return $this->process($request, $handler);
    }

    public function requestTicketValidation(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        $handler = new RequestTicketValidation(
            $this->cas,
            $this->psr17,
            $this->properties,
            $parameters
        );

        return $this->process($request, $handler);
    }

    public function supportAuthentication(
        ServerRequestInterface $request,
        array $parameters = []
    ): bool {
        return $this
            ->cas
            ->supportAuthentication(
                $request,
                (new Parameters())->addTicketFromRequestHeaders($request, $parameters)
            );
    }
}
