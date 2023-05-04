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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RemoveClientFingerprintCookie implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return FigResponseCookies::remove(
            $request->getAttribute('response'),
            AttachClientFingerprintCookie::CLIENT_FINGERPRINT_ATTRIBUTE
        );
    }
}
