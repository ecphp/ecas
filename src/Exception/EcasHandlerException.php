<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Exception;

use EcPhp\CasLib\Exception\CasExceptionInterface;
use EcPhp\Ecas\Contract\Response\Type\LoginRequestFailure;
use Exception;

final class EcasHandlerException extends Exception implements CasExceptionInterface
{
    public static function badResponseAttribute(): self
    {
        return new self(
            'The response attribute in the request must be of type ResponseInterface.'
        );
    }

    public static function loginRequestFailure(LoginRequestFailure $response): self
    {
        return new self(
            sprintf('ECAS login request failure: %s', $response->getError())
        );
    }
}
