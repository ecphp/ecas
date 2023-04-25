<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Service;

use Psr\Http\Message\ServerRequestInterface;

final class Parameters
{
    /**
     * Extract ticket from the request and update parameters array with it.
     */
    public function addTicketFromRequestHeaders(ServerRequestInterface $request, array $parameters): array
    {
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
