<?php

declare(strict_types=1);

namespace EcPhp\Ecas;

use EcPhp\CasLib\CasInterface;
use EcPhp\CasLib\Configuration\PropertiesInterface;
use EcPhp\CasLib\Utils\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class Ecas implements CasInterface
{
    /**
     * @var CasInterface
     */
    private $cas;

    /**
     * @var ServerRequestInterface
     */
    private $serverRequest;

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    public function __construct(CasInterface $cas, StreamFactoryInterface $streamFactory, ServerRequestInterface $serverRequest)
    {
        $this->cas = $cas;
        $this->streamFactory = $streamFactory;
        $this->serverRequest = $serverRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(): ?array
    {
        return $this->cas->authenticate();
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
        if (false === $this->supportAuthentication()) {
            return null;
        }

        // check for ticket in Authorization header as provided by OpenId
        // Authorization: cas_ticket PT-226194-QdoP...
        $ticketStr = $this->serverRequest->getHeader('Authorization') ?? '';

        /** @var string $ticket */
        $ticket = preg_replace('/^cas_ticket /i', '', $ticketStr);

        if ('' === $ticket) {
            $ticket = Uri::getParam(
                $this->serverRequest->getUri(),
                'ticket',
                ''
            );
        }

        $parameters += ['ticket' => $ticket];

        if (true === $this->proxyMode()) {
            return $this->cas->requestProxyValidate($parameters, $response);
        }

        return $this->cas->requestServiceValidate($parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function supportAuthentication(): bool
    {
        return $this->cas->supportAuthentication();
    }

    /**
     * {@inheritdoc}
     */
    public function withServerRequest(ServerRequestInterface $serverRequest): CasInterface
    {
        $clone = clone $this;
        $clone->cas = $clone->cas->withServerRequest($serverRequest);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    private function proxyMode(): bool
    {
        return isset($this->getProperties()['protocol']['serviceValidate']['default_parameters']['pgtUrl']);
    }
}
