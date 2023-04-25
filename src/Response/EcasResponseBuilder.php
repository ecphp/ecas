<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Response;

use EcPhp\CasLib\Contract\Response\CasResponseBuilderInterface;
use EcPhp\CasLib\Contract\Response\CasResponseInterface;
use EcPhp\CasLib\Exception\CasResponseBuilderException;
use EcPhp\CasLib\Utils\Response as ResponseUtils;
use EcPhp\Ecas\Contract\Response\Factory\LoginRequestFactory as LoginRequestFactoryInterface;
use EcPhp\Ecas\Contract\Response\Factory\LoginRequestFailureFactory as LoginRequestFailureFactoryInterface;
use EcPhp\Ecas\Response\Factory\LoginRequestFactory;
use EcPhp\Ecas\Response\Factory\LoginRequestFailureFactory;
use Psr\Http\Message\ResponseInterface;
use Throwable;

use function array_key_exists;

final class EcasResponseBuilder implements CasResponseBuilderInterface
{
    public function __construct(
        private readonly CasResponseBuilderInterface $casResponseBuilderInterface,
        private readonly LoginRequestFactoryInterface $loginRequestFactory = new LoginRequestFactory(),
        private readonly LoginRequestFailureFactoryInterface $loginRequestFailureFactory = new LoginRequestFailureFactory()
    ) {
    }

    public function fromResponse(ResponseInterface $response): CasResponseInterface
    {
        try {
            return $this->casResponseBuilderInterface->fromResponse($response);
        } catch (Throwable $exception) {
        }

        $data = (new ResponseUtils())->toArray($response);

        if (false === array_key_exists('loginRequest', $data)) {
            throw CasResponseBuilderException::invalidResponseType();
        }

        if (array_key_exists('loginRequestFailure', $data['loginRequest'])) {
            return $this->loginRequestFailureFactory->decorate($response);
        }

        if (array_key_exists('loginRequestSuccess', $data['loginRequest'])) {
            return $this->loginRequestFactory->decorate($response);
        }

        throw CasResponseBuilderException::unknownResponseType();
    }
}
