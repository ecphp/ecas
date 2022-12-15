<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas;

use EcPhp\CasLib\CasInterface;
use EcPhp\CasLib\Configuration\PropertiesInterface;
use EcPhp\CasLib\Introspection\Contract\IntrospectionInterface;
use EcPhp\CasLib\Introspection\Contract\ServiceValidate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

final class Ecas implements CasInterface
{
    private CasInterface $cas;

    private ServerRequestInterface $serverRequest;

    private StreamFactoryInterface $streamFactory;

    public function __construct(CasInterface $cas, StreamFactoryInterface $streamFactory)
    {
        $this->cas = $cas;
        $this->streamFactory = $streamFactory;
    }

    public function authenticate(array $parameters = []): ?array
    {
        return $this->cas->authenticate($parameters);
    }

    public function detect(ResponseInterface $response): IntrospectionInterface
    {
        return $this->cas->detect($response);
    }

    public function getProperties(): PropertiesInterface
    {
        return $this->cas->getProperties();
    }

    public function handleProxyCallback(
        array $parameters = [],
        ?ResponseInterface $response = null
    ): ?ResponseInterface {
        $body = '<?xml version="1.0" encoding="utf-8"?><proxySuccess xmlns="http://www.yale.edu/tp/casClient" />';

        $response = $this
            ->cas
            ->handleProxyCallback($parameters, $response);

        if (null !== $response) {
            return $response->withBody(
                $this
                    ->streamFactory
                    ->createStream($body)
            );
        }

        return $response;
    }

    public function login(array $parameters = []): ?ResponseInterface
    {
        return $this->cas->login($parameters);
    }

    public function logout(array $parameters = []): ?ResponseInterface
    {
        return $this->cas->logout($parameters);
    }

    public function requestProxyTicket(
        array $parameters = [],
        ?ResponseInterface $response = null
    ): ?ResponseInterface {
        return $this->cas->requestProxyTicket($parameters, $response);
    }

    public function requestProxyValidate(
        array $parameters = [],
        ?ResponseInterface $response = null
    ): ?ResponseInterface {
        return $this->cas->requestProxyValidate($parameters, $response);
    }

    public function requestServiceValidate(
        array $parameters = [],
        ?ResponseInterface $response = null
    ): ?ResponseInterface {
        return $this->cas->requestServiceValidate($parameters, $response);
    }

    public function requestTicketValidation(
        array $parameters = [],
        ?ResponseInterface $response = null
    ): ?ResponseInterface {
        if ('' !== $ticket = $this->extractTicketFromRequestHeaders()) {
            $parameters += ['ticket' => $ticket];
        }

        if (null === $response = $this->cas->requestTicketValidation($parameters, $response)) {
            return null;
        }

        try {
            $introspect = $this->detect($response);
        } catch (Throwable $e) {
            return null;
        }

        if (!$introspect instanceof ServiceValidate) {
            return null;
        }

        $authenticationLevelFromResponse = $introspect->getParsedResponse()['serviceResponse']['authenticationSuccess']['attributes']['authenticationLevel'] ?? EcasProperties::AUTHENTICATION_LEVEL_BASIC;
        $authenticationLevelFromConfiguration = $this->cas->getProperties()['protocol']['login']['default_parameters']['authenticationLevel'];

        if (EcasProperties::AUTHENTICATION_LEVELS[$authenticationLevelFromResponse] < EcasProperties::AUTHENTICATION_LEVELS[$authenticationLevelFromConfiguration]) {
            return null;
        }

        return $response;
    }

    public function supportAuthentication(array $parameters = []): bool
    {
        if ('' !== $ticket = $this->extractTicketFromRequestHeaders()) {
            $parameters += ['ticket' => $ticket];
        }

        return $this->cas->supportAuthentication($parameters);
    }

    public function withServerRequest(ServerRequestInterface $serverRequest): CasInterface
    {
        $clone = clone $this;
        $clone->serverRequest = $serverRequest;
        $clone->cas = $clone->cas->withServerRequest($serverRequest);

        return $clone;
    }

    /**
     * Extract ticket from $request.
     */
    private function extractTicketFromRequestHeaders(): string
    {
        // check for ticket in Authorization header as provided by OpenId
        // Authorization: cas_ticket PT-226194-QdoP...

        return (string) preg_replace(
            '/^cas_ticket /i',
            '',
            $this->serverRequest->getHeaderLine('Authorization') ?? ''
        );
    }
}
