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
use EcPhp\CasLib\Contract\Response\CasResponseInterface;
use Exception;
use loophp\psr17\Psr17Interface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Ecas implements CasInterface
{
    private CasInterface $cas;

    private PropertiesInterface $properties;

    private Psr17Interface $psr17;

    public function __construct(
        CasInterface $cas,
        PropertiesInterface $casProperties,
        Psr17Interface $psr17
    ) {
        $this->cas = $cas;
        $this->properties = $casProperties;
        $this->psr17 = $psr17;
    }

    public function authenticate(
        ServerRequestInterface $request,
        array $parameters = []
    ): array {
        return $this->cas->authenticate($request, $parameters);
    }

    public function handleProxyCallback(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        $response = $this
            ->cas
            ->handleProxyCallback($request, $parameters);

        $body = '<?xml version="1.0" encoding="utf-8"?><proxySuccess xmlns="http://www.yale.edu/tp/casClient" />';

        return $response
            ->withBody(
                $this
                    ->psr17
                    ->createStream($body)
            );
    }

    public function login(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        return $this->cas->login($request, $parameters);
    }

    public function logout(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        return $this->cas->logout($request, $parameters);
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
        return $this->cas->requestProxyTicket($request, $parameters);
    }

    public function requestServiceValidate(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        return $this->cas->requestServiceValidate($request, $parameters);
    }

    public function requestTicketValidation(
        ServerRequestInterface $request,
        array $parameters = []
    ): ResponseInterface {
        if ('' !== $ticket = $this->extractTicketFromRequestHeaders($request)) {
            $parameters += ['ticket' => $ticket];
        }

        /** @var CasResponseInterface $response */
        $response = $this->cas->requestTicketValidation($request, $parameters);

        $authenticationLevelFromResponse = $response->toArray()['serviceResponse']['authenticationSuccess']['attributes']['authenticationLevel'] ?? EcasProperties::AUTHENTICATION_LEVEL_BASIC;
        $authenticationLevelFromConfiguration = $this->properties['protocol']['login']['default_parameters']['authenticationLevel'];

        if (EcasProperties::AUTHENTICATION_LEVELS[$authenticationLevelFromResponse] < EcasProperties::AUTHENTICATION_LEVELS[$authenticationLevelFromConfiguration]) {
            throw new Exception('Unable to validate ticket: invalid authentication level.');
        }

        return $response;
    }

    public function supportAuthentication(
        ServerRequestInterface $request,
        array $parameters = []
    ): bool {
        if ('' !== $ticket = $this->extractTicketFromRequestHeaders($request)) {
            $parameters += ['ticket' => $ticket];
        }

        return $this->cas->supportAuthentication($request, $parameters);
    }

    /**
     * Extract ticket from $request.
     */
    private function extractTicketFromRequestHeaders(ServerRequestInterface $request): string
    {
        // check for ticket in Authorization header as provided by OpenId
        // Authorization: cas_ticket PT-226194-QdoP...

        return (string) preg_replace(
            '/^cas_ticket /i',
            '',
            $request->getHeaderLine('Authorization') ?? ''
        );
    }
}
