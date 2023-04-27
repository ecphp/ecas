<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace spec\EcPhp\Ecas\Handler;

use EcPhp\CasLib\Cas;
use EcPhp\CasLib\Exception\CasHandlerException;
use EcPhp\CasLib\Exception\CasResponseBuilderException;
use EcPhp\CasLib\Response\CasResponseBuilder;
use EcPhp\Ecas\Handler\LoginTransaction;
use EcPhp\Ecas\Response\EcasResponseBuilder;
use Ergebnis\Http\Method;
use loophp\psr17\Psr17;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use spec\EcPhp\Ecas\CasHelper;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpClient\Psr18Client;

class LoginTransactionSpec extends ObjectBehavior
{
    public function it_can_handle_a_login_response_with_wrong_structure()
    {
        $request = new ServerRequest(
            Method::GET,
            'http://foobar/',
        );

        $this
            ->shouldThrow(CasResponseBuilderException::class)
            ->during(
                'handle',
                [
                    $request
                        ->withAttribute('response', new Response(200, ['Location' => 'http://local/cas/login/bad-structure'])),
                ]
            );
    }

    public function it_can_handle_a_request()
    {
        $request = new ServerRequest(
            Method::GET,
            'http://foobar/',
        );

        $response = $this
            ->handle(
                $request
                    ->withAttribute('response', new Response(200, ['Location' => 'http://local/cas/login/success?foo=bar']))
            );

        $response
            ->shouldBeAnInstanceOf(ResponseInterface::class);

        $response
            ->getHeaderLine('Location')
            ->shouldReturn('http://local/cas/login/success?loginRequestId=ECAS_LR-foo%3Dbar');

        $response
            ->getStatusCode()
            ->shouldReturn(302);
    }

    public function it_can_handle_a_request_with_a_failure()
    {
        $request = new ServerRequest(
            Method::GET,
            'http://foobar/',
        );

        $this
            ->shouldThrow(CasHandlerException::class)
            ->during(
                'handle',
                [
                    $request
                        ->withAttribute('response', new Response(200, ['Location' => 'http://local/cas/login/failure'])),
                ]
            );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LoginTransaction::class);
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
        $client = new Psr18Client(CasHelper::getHttpClientMock());
        $ecasResponseBuilder = new EcasResponseBuilder(new CasResponseBuilder());

        $cas = new Cas(
            $properties,
            $client,
            $psr17,
            new ArrayAdapter(),
            $ecasResponseBuilder
        );

        $this
            ->beConstructedWith(
                $cas,
                $psr17,
                $ecasResponseBuilder,
                $client,
            );
    }
}
