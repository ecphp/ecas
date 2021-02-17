<?php

declare(strict_types=1);

namespace EcPhp\Ecas;

use EcPhp\CasLib\CasInterface;
use EcPhp\CasLib\Configuration\PropertiesInterface;
use EcPhp\CasLib\Introspection\Contract\IntrospectionInterface;
use EcPhp\CasLib\Utils\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class Ecas implements CasInterface
{
    /**
     * @var \EcPhp\CasLib\CasInterface
     */
    private $cas;

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    private $serverRequest;

    /**
     * @var \Psr\Http\Message\StreamFactoryInterface
     */
    private $streamFactory;

    public function __construct(CasInterface $cas, StreamFactoryInterface $streamFactory)
    {
        $this->cas = $cas;
        $this->streamFactory = $streamFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(array $parameters = []): ?array
    {
        return $this->cas->authenticate($parameters);
    }

    public function detect(ResponseInterface $response): IntrospectionInterface
    {
        return $this->cas->detect($response);
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties(): PropertiesInterface
    {
        return $this->cas->getProperties();
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function login(array $parameters = []): ?ResponseInterface
    {
        return $this->cas->login($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function logout(array $parameters = []): ?ResponseInterface
    {
        return $this->cas->logout($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function requestProxyTicket(
        array $parameters = [],
        ?ResponseInterface $response = null
    ): ?ResponseInterface {
        return $this->cas->requestProxyTicket($parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function requestProxyValidate(
        array $parameters = [],
        ?ResponseInterface $response = null
    ): ?ResponseInterface {
        return $this->cas->requestProxyValidate($parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function requestServiceValidate(
        array $parameters = [],
        ?ResponseInterface $response = null
    ): ?ResponseInterface {
        return $this->cas->requestServiceValidate($parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function requestTicketValidation(
        array $parameters = [],
        ?ResponseInterface $response = null
    ): ?ResponseInterface {
        if ('' !== $ticket = $this->extractTicketFromRequestHeaders()) {
            $parameters += ['ticket' => $ticket];
        }

        /** @var string $ticket */
        $ticket = Uri::getParam(
            $this->serverRequest->getUri(),
            'ticket',
            ''
        );

        $parameters += ['ticket' => $ticket];

        $parameters['ticket'] = preg_replace(
            '/^pop /',
            '',
            $parameters['ticket']
        );

        return $this->cas->requestTicketValidation($parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function supportAuthentication(array $parameters = []): bool
    {
        if ('' !== $ticket = $this->extractTicketFromRequestHeaders()) {
            $parameters += ['ticket' => $ticket];
        }

        return $this->cas->supportAuthentication($parameters);
    }

    /**
     * {@inheritdoc}
     */
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
