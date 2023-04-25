<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace spec\EcPhp\Ecas;

use EcPhp\CasLib\Cas;
use EcPhp\CasLib\Response\CasResponseBuilder;
use Ergebnis\Http\Method;
use Exception;
use loophp\psr17\Psr17;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\ServerRequest;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpClient\Psr18Client;

require_once __DIR__ . '/CasHelper.php';

class EcasSpec extends ObjectBehavior
{
    public function it_can_do_a_service_ticket_validation_and_make_sure_authenticationLevel_is_correct()
    {
        $request = new ServerRequest(
            Method::GET,
            'http://local/'
        );

        $this
            ->requestTicketValidation(
                $request,
                ['service' => 'service', 'ticket' => 'authenticationLevel_feature_success']
            )
            ->shouldBeAnInstanceOf(ResponseInterface::class);

        $this
            ->requestTicketValidation(
                $request,
                ['service' => 'service', 'ticket' => 'authenticationLevel_high']
            )
            ->shouldBeAnInstanceOf(ResponseInterface::class);

        $this
            ->shouldThrow(Exception::class)
            ->during('requestTicketValidation', [
                $request,
                ['service' => 'service', 'ticket' => 'authenticationLevel_basic'],
            ]);
    }

    public function it_can_do_a_service_ticket_validation_with_a_request_header()
    {
        $request = new ServerRequest(
            Method::GET,
            'http://local/',
            ['Authorization' => 'cas_ticket ticket']
        );

        $this
            ->requestTicketValidation($request, ['service' => 'service'])
            ->shouldBeAnInstanceOf(ResponseInterface::class);

        $request = new ServerRequest(
            Method::GET,
            'http://local/'
        );

        $this
            ->shouldThrow(Exception::class)
            ->during('requestTicketValidation', [$request, ['service' => 'service']]);

        // Make sure that if a service is passed through the argument, it is
        // not overridden.
        $request = new ServerRequest(
            Method::GET,
            'http://local/',
            ['Authorization' => 'cas_ticket foo']
        );

        $this
            ->requestTicketValidation($request, ['service' => 'service', 'ticket' => 'ticket'])
            ->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_is_returning_xml_on_the_proxycallback()
    {
        $request = new ServerRequest(
            Method::GET,
            'http://local/proxycallback?pgtId=pgtId&pgtIou=pgtIou'
        );

        $this
            ->handleProxyCallback($request)
            ->shouldReturnAnInstanceOf(ResponseInterface::class);

        $this
            ->handleProxyCallback($request)
            ->getBody()
            ->__toString()
            ->shouldReturn('<?xml version="1.0" encoding="utf-8"?><proxySuccess xmlns="http://www.yale.edu/tp/casClient" />');

        $this
            ->handleProxyCallback($request)
            ->getStatusCode()
            ->shouldReturn(200);

        $request = new ServerRequest(
            Method::GET,
            'http://local/proxycallback?pgtId=pgtId'
        );

        $this
            ->shouldThrow(Exception::class)
            ->during('handleProxyCallback', [$request]);

        $request = new ServerRequest(
            Method::GET,
            'http://local/proxycallback?pgtIou=pgtIou'
        );

        $this
            ->shouldThrow(Exception::class)
            ->during('handleProxyCallback', [$request]);
    }

    public function it_support_authentication_when_a_ticket_is_in_the_request_header()
    {
        $request = new ServerRequest(
            Method::GET,
            'http://local/',
            ['Authorization' => 'cas_ticket ticket']
        );

        $this
            ->supportAuthentication($request)
            ->shouldReturn(true);

        $request = new ServerRequest(
            'GET',
            'http://local/',
        );

        $this
            ->supportAuthentication($request)
            ->shouldReturn(false);

        // Make sure that if a service is passed through the argument, it is
        // not overridden.
        $request = new ServerRequest(
            'GET',
            'http://local/',
            ['Authorization' => 'cas_ticket foo']
        );

        $this
            ->supportAuthentication($request, ['service' => 'service', 'ticket' => 'ticket'])
            ->shouldReturn(true);
    }

    public function let()
    {
        $psr17Factory = new Psr17Factory();
        $psr17 = new Psr17(
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory
        );

        $properties = CasHelper::getTestProperties();
        $casResponseBuilder = new CasResponseBuilder();

        $cas = new Cas(
            $properties,
            new Psr18Client(CasHelper::getHttpClientMock()),
            $psr17,
            new ArrayAdapter(),
            $casResponseBuilder
        );

        $this
            ->beConstructedWith(
                $cas,
                $properties,
                $psr17,
                $casResponseBuilder
            );
    }
}
