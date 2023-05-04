<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace spec\EcPhp\Ecas\Handler;

use EcPhp\Ecas\Handler\AttachClientFingerprintCookie;
use Ergebnis\Http\Method;
use loophp\psr17\Psr17Interface;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class AttachClientFingerprintCookieSpec extends ObjectBehavior
{
    public function it_can_attach_a_client_fingerprint_cookie()
    {
        $request = new ServerRequest(
            Method::GET,
            'http://foobar/',
        );

        $response = $this
            ->handle(
                $request
                    ->withAttribute('response', new Response(200))
                    ->withAttribute(AttachClientFingerprintCookie::CLIENT_FINGERPRINT_ATTRIBUTE, 'foo')
            );

        $response
            ->shouldBeAnInstanceOf(ResponseInterface::class);

        $response
            ->getHeaderLine('Set-Cookie')
            ->shouldReturn('clientFingerprint=Zm9v; Secure; HttpOnly; SameSite=Lax');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AttachClientFingerprintCookie::class);
    }

    public function let(Psr17Interface $psr17)
    {
        $this->beConstructedWith($psr17);
    }
}
