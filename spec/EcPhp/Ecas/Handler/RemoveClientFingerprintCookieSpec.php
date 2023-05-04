<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace spec\EcPhp\Ecas\Handler;

use EcPhp\Ecas\Handler\RemoveClientFingerprintCookie;
use Ergebnis\Http\Method;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class RemoveClientFingerprintCookieSpec extends ObjectBehavior
{
    public function it_can_remove_a_client_fingerprint_cookie()
    {
        $request = new ServerRequest(
            Method::GET,
            'http://foobar/',
        );

        $response = $this
            ->handle(
                $request
                    ->withAttribute(
                        'response',
                        (new Response(200))
                            ->withHeader('Set-Cookie', 'clientFingerprint=Zm9v; Secure; HttpOnly; SameSite=Lax')
                    )
            );

        $response
            ->shouldBeAnInstanceOf(ResponseInterface::class);

        $response
            ->getHeaderLine('Set-Cookie')
            ->shouldReturn('');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RemoveClientFingerprintCookie::class);
    }
}
