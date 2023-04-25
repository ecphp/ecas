<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Contract\Response\Type;

use EcPhp\CasLib\Contract\Response\CasResponseInterface;

interface LoginRequest extends CasResponseInterface
{
    public function getTransactionId(): string;
}
