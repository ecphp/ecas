<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Response\Factory;

use EcPhp\CasLib\Contract\Response\Factory\ServiceValidateFactory as ServiceValidateFactoryInterface;
use EcPhp\CasLib\Contract\Response\Type\ServiceValidate as ServiceValidateInterface;
use loophp\psr17\Psr17Interface;
use Psr\Http\Message\ResponseInterface;

use function in_array;

final class ServiceValidateFactory implements ServiceValidateFactoryInterface
{
    private Psr17Interface $psr17;

    private ServiceValidateFactoryInterface $serviceValidateFactory;

    public function __construct(ServiceValidateFactoryInterface $serviceValidateFactory, Psr17Interface $psr17)
    {
        $this->serviceValidateFactory = $serviceValidateFactory;
        $this->psr17 = $psr17;
    }

    public function decorate(ResponseInterface $response): ServiceValidateInterface
    {
        $response = $this
            ->serviceValidateFactory
            ->decorate($response);

        return $response
            ->withHeader(
                'Content-Type',
                'application/json'
            )
            ->withBody(
                $this
                    ->psr17
                    ->createStream(
                        json_encode(
                            $this->normalizeUserData($response->toArray())
                        )
                    )
            );
    }

    /**
     * Normalize user data from EU Login to standard CAS user data.
     *
     * @param array<array|string> $data
     *   The data from EU Login
     *
     * @return array<array|string>
     *   The normalized data.
     */
    private function normalizeUserData(array $data): array
    {
        $data = $data['serviceResponse']['authenticationSuccess'];
        $data += ['attributes' => []];

        $rootAttributes = ['user', 'proxyGrantingTicket', 'proxies', 'attributes'];

        foreach ($data as $key => $property) {
            if (in_array($key, $rootAttributes, true)) {
                continue;
            }

            $data['attributes'] += [$key => $property];
            unset($data[$key]);
        }

        return [
            'serviceResponse' => [
                'authenticationSuccess' => $data,
            ],
        ];
    }
}
