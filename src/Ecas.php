<?php

declare(strict_types=1);

namespace EcPhp\Ecas;

use EcPhp\CasLib\CasInterface;
use EcPhp\CasLib\Configuration\PropertiesInterface;
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
        return $this->cas->requestTicketValidation($parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function supportAuthentication(array $parameters = []): bool
    {
        return $this->cas->supportAuthentication($parameters);
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
}
