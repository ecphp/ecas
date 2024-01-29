<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Handler;

use EcPhp\CasLib\Contract\CasInterface;
use EcPhp\CasLib\Contract\Configuration\PropertiesInterface;
use EcPhp\CasLib\Contract\Handler\HandlerInterface;
use EcPhp\Ecas\EcasProperties;
use EcPhp\Ecas\Service\Parameters;
use Exception;
use loophp\psr17\Psr17Interface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestTicketValidation implements RequestHandlerInterface
{
    public function __construct(
        private readonly CasInterface $cas,
        private readonly Psr17Interface $psr17,
        private readonly PropertiesInterface $properties
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parameters = (new Parameters())->addTicketFromRequestHeaders($request);

        /** @var \EcPhp\CasLib\Contract\Response\Type\ServiceValidate $response */
        $response = $this->cas->requestTicketValidation($request, $parameters);

        $authenticationLevelFromResponse = $response->toArray()['serviceResponse']['authenticationSuccess']['authenticationLevel'] ?? EcasProperties::AUTHENTICATION_LEVEL_BASIC;
        $authenticationLevelFromConfiguration = $this->properties->jsonSerialize()['protocol'][HandlerInterface::TYPE_LOGIN]['default_parameters']['authenticationLevel'];

        if (EcasProperties::AUTHENTICATION_LEVELS[$authenticationLevelFromResponse] < EcasProperties::AUTHENTICATION_LEVELS[$authenticationLevelFromConfiguration]) {
            throw new Exception('Unable to validate ticket: invalid authentication level.');
        }

        return $response;
    }
}
