<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Handler;

use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\Modifier\SameSite;
use Dflydev\FigCookies\SetCookie;
use loophp\psr17\Psr17Interface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class AttachClientFingerprintCookie implements RequestHandlerInterface
{
    public const CLIENT_FINGERPRINT_ATTRIBUTE = 'clientFingerprint';

    public function __construct(
        private readonly Psr17Interface $psr17
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return FigResponseCookies::set(
            $request->getAttribute('response'),
            SetCookie::create(self::CLIENT_FINGERPRINT_ATTRIBUTE)
                ->withValue(base64_encode($request->getAttribute(self::CLIENT_FINGERPRINT_ATTRIBUTE)))
                ->withSecure(true)
                ->withHttpOnly(true)
                ->withSameSite(SameSite::lax())
        );
    }
}
