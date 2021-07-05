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
use EcPhp\CasLib\Introspection\Introspector;
use EcPhp\Ecas\Introspection\EcasIntrospector;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\ServerRequest;
use Nyholm\Psr7Server\ServerRequestCreator;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpClient\Psr18Client;

require_once __DIR__ . '/CasHelper.php';

class EcasSpec extends ObjectBehavior
{
    public function it_can_do_a_service_ticket_validation_with_a_request_header()
    {
        $from = 'http://local/';
        $request = new ServerRequest('GET', $from, ['Authorization' => 'cas_ticket ticket']);

        $this
            ->withServerRequest($request)
            ->requestTicketValidation(['service' => 'service'])
            ->shouldBeAnInstanceOf(ResponseInterface::class);

        $from = 'http://local/';
        $request = new ServerRequest('GET', $from);

        $this
            ->withServerRequest($request)
            ->requestTicketValidation(['service' => 'service'])
            ->shouldBeNull();

        // Make sure that if a service is passed through the argument, it is
        // not overridden.
        $from = 'http://local/';
        $request = new ServerRequest('GET', $from, ['Authorization' => 'cas_ticket foo']);

        $this
            ->withServerRequest($request)
            ->requestTicketValidation(['service' => 'service', 'ticket' => 'ticket'])
            ->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_is_returning_xml_on_the_proxycallback()
    {
        $request = new ServerRequest('GET', 'http://local/proxycallback?pgtId=pgtId&pgtIou=pgtIou');

        $this
            ->withServerRequest($request)
            ->handleProxyCallback()
            ->shouldReturnAnInstanceOf(ResponseInterface::class);

        $this
            ->withServerRequest($request)
            ->handleProxyCallback()
            ->getBody()
            ->__toString()
            ->shouldReturn('<?xml version="1.0" encoding="utf-8"?><proxySuccess xmlns="http://www.yale.edu/tp/casClient" />');

        $this
            ->withServerRequest($request)
            ->handleProxyCallback()
            ->getStatusCode()
            ->shouldReturn(200);

        $request = new ServerRequest('GET', 'http://local/proxycallback?pgtId=pgtId');

        $this
            ->withServerRequest($request)
            ->handleProxyCallback()
            ->getStatusCode()
            ->shouldReturn(500);

        $request = new ServerRequest('GET', 'http://local/proxycallback?pgtIou=pgtIou');

        $this
            ->withServerRequest($request)
            ->handleProxyCallback()
            ->getStatusCode()
            ->shouldReturn(500);
    }

    public function it_support_authentication_when_a_ticket_is_in_the_request_header()
    {
        $from = 'http://local/';
        $request = new ServerRequest('GET', $from, ['Authorization' => 'cas_ticket ticket']);

        $this
            ->withServerRequest($request)
            ->supportAuthentication()
            ->shouldReturn(true);

        $from = 'http://local/';
        $request = new ServerRequest('GET', $from);

        $this
            ->withServerRequest($request)
            ->supportAuthentication()
            ->shouldReturn(false);

        // Make sure that if a service is passed through the argument, it is
        // not overridden.
        $from = 'http://local/';
        $request = new ServerRequest('GET', $from, ['Authorization' => 'cas_ticket foo']);

        $this
            ->withServerRequest($request)
            ->supportAuthentication(['service' => 'service', 'ticket' => 'ticket'])
            ->shouldReturn(true);
    }

    public function let()
    {
        $psr17Factory = new Psr17Factory();
        $creator = new ServerRequestCreator(
            $psr17Factory, // ServerRequestFactory
            $psr17Factory, // UriFactory
            $psr17Factory, // UploadedFileFactory
            $psr17Factory  // StreamFactory
        );

        $cas = new Cas(
            $creator->fromGlobals(),
            CasHelper::getTestProperties(),
            new Psr18Client(CasHelper::getHttpClientMock()),
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            new ArrayAdapter(),
            new NullLogger(),
            new EcasIntrospector(new Introspector())
        );

        $this->beConstructedWith($cas, $psr17Factory);
    }
}
