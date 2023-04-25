<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Response\Factory;

use EcPhp\Ecas\Contract\Response\Factory\LoginRequestFailureFactory as LoginRequestFailureFactoryInterface;
use EcPhp\Ecas\Contract\Response\Type\LoginRequestFailure as LoginRequestFailureInterface;
use EcPhp\Ecas\Response\Type\LoginRequestFailure;
use Psr\Http\Message\ResponseInterface;

final class LoginRequestFailureFactory implements LoginRequestFailureFactoryInterface
{
    public function decorate(ResponseInterface $response): LoginRequestFailureInterface
    {
        return new LoginRequestFailure($response);
    }
}
