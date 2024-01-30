<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace spec\EcPhp\Ecas\Handler;

use EcPhp\CasLib\Contract\CasInterface;
use Ergebnis\Http\Method;
use loophp\psr17\Psr17;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProxyCallbackSpec extends ObjectBehavior
{
    public function it_can_pgtIou_and_pgtId_using_POST_method(CasInterface $cas)
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

        $request = (new ServerRequest(Method::POST, 'http://foobar/'))
            ->withParsedBody(['pgtId' => 'pgtId', 'pgtIou' => 'pgtIou']);

        $cas
            ->handleProxyCallback($request, Argument::type('array'))
            ->willReturn(new Response());

        $this->beConstructedWith($cas, $psr17);
        $this->handle($request);

        $cas
            ->handleProxyCallback($request, ['pgtId' => 'pgtId', 'pgtIou' => 'pgtIou'])
            ->shouldHaveBeenCalled();
    }

    public function it_check_if_parameters_can_be_overridden(CasInterface $cas)
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

        $request = (new ServerRequest(Method::POST, 'http://foobar/'))
            ->withParsedBody(['pgtId' => 'pgtId', 'pgtIou' => 'pgtIou'])
            ->withAttribute('parameters', ['pgtId' => 'pgtIdOverridden']);

        $cas
            ->handleProxyCallback($request, Argument::type('array'))
            ->willReturn(new Response());

        $this->beConstructedWith($cas, $psr17);
        $this->handle($request);

        $cas
            ->handleProxyCallback($request, ['pgtId' => 'pgtIdOverridden', 'pgtIou' => 'pgtIou'])
            ->shouldHaveBeenCalled();
    }
}
