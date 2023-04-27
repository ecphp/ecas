<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Contract\Response\Factory;

use EcPhp\Ecas\Contract\Response\Type\LoginRequestFailure;
use Psr\Http\Message\ResponseInterface;

interface LoginRequestFailureFactory
{
    public function decorate(ResponseInterface $response): LoginRequestFailure;
}
