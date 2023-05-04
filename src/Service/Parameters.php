<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Service;

use Dflydev\FigCookies\FigRequestCookies;
use EcPhp\Ecas\Handler\AttachClientFingerprintCookie;
use Psr\Http\Message\ServerRequestInterface;

final class Parameters
{
    public function addFingerprintFromCookie(ServerRequestInterface $request): array
    {
        $parameters = $request->getAttribute('parameters', []);

        $clientFingerprintCookie = FigRequestCookies::get(
            $request,
            AttachClientFingerprintCookie::CLIENT_FINGERPRINT_ATTRIBUTE
        );

        if (null !== $fingerprint = $clientFingerprintCookie->getValue()) {
            $parameters[AttachClientFingerprintCookie::CLIENT_FINGERPRINT_ATTRIBUTE] = $fingerprint;
        }

        return $parameters;
    }

    public function addFingerprintParameter(ServerRequestInterface $request): array
    {
        $parameters = $request->getAttribute('parameters', []);
        $fingerprint = $request->getAttribute(AttachClientFingerprintCookie::CLIENT_FINGERPRINT_ATTRIBUTE, '');

        $parameters[AttachClientFingerprintCookie::CLIENT_FINGERPRINT_ATTRIBUTE] = base64_encode(sha1(sha1($fingerprint, true), true));

        return $parameters;
    }

    /**
     * Extract ticket from the request.
     */
    public function addTicketFromRequestHeaders(ServerRequestInterface $request): array
    {
        $parameters = $request->getAttribute('parameters', []);

        // check for ticket in Authorization header as provided by OpenId
        // Authorization: cas_ticket PT-226194-QdoP...
        $ticket = (string) preg_replace(
            '/^cas_ticket /i',
            '',
            $request->getHeaderLine('Authorization')
        );

        if ('' !== $ticket) {
            $parameters += ['ticket' => $ticket];
        }

        return $parameters;
    }
}
