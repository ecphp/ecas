<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Response\Factory;

use EcPhp\Ecas\Contract\Response\Factory\LoginRequestFactory as LoginRequestFactoryInterface;
use EcPhp\Ecas\Contract\Response\Type\LoginRequest as LoginRequestInterface;
use EcPhp\Ecas\Response\Type\LoginRequest;
use Psr\Http\Message\ResponseInterface;

final class LoginRequestFactory implements LoginRequestFactoryInterface
{
    public function decorate(ResponseInterface $response): LoginRequestInterface
    {
        return new LoginRequest($response);
    }
}
