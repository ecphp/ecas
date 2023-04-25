<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Response\Type;

use EcPhp\CasLib\Response\Type\CasResponse;
use EcPhp\Ecas\Contract\Response\Type\LoginRequest as LoginRequestInterface;

final class LoginRequest extends CasResponse implements LoginRequestInterface
{
    public function getTransactionId(): string
    {
        return $this->toArray()['loginRequest']['loginRequestSuccess']['loginRequestId'];
    }
}
