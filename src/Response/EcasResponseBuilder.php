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
use EcPhp\CasLib\Contract\Response\Type\AuthenticationFailure;
use EcPhp\CasLib\Contract\Response\Type\Proxy;
use EcPhp\CasLib\Contract\Response\Type\ProxyFailure;
use EcPhp\CasLib\Contract\Response\Type\ServiceValidate as TypeServiceValidate;
use loophp\psr17\Psr17Interface;
use Psr\Http\Message\ResponseInterface;

use function in_array;

final class EcasResponseBuilder implements CasResponseBuilderInterface
{
    private CasResponseBuilderInterface $casResponseBuilder;

    private Psr17Interface $psr17;

    public function __construct(
        CasResponseBuilderInterface $casResponseBuilder,
        Psr17Interface $psr17
    ) {
        $this->casResponseBuilder = $casResponseBuilder;
        $this->psr17 = $psr17;
    }

    public function createAuthenticationFailure(ResponseInterface $response): AuthenticationFailure
    {
        return $this->casResponseBuilder->createAuthenticationFailure($response);
    }

    public function createProxyFailure(ResponseInterface $response): ProxyFailure
    {
        return $this->casResponseBuilder->createProxyFailure($response);
    }

    public function createProxySuccess(ResponseInterface $response): Proxy
    {
        return $this->casResponseBuilder->createProxySuccess($response);
    }

    public function createServiceValidate(ResponseInterface $response): TypeServiceValidate
    {
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

    public function fromResponse(ResponseInterface $response): CasResponseInterface
    {
        $response = $this->casResponseBuilder->fromResponse($response);

        if ($response instanceof TypeServiceValidate) {
            return $this->createServiceValidate($response);
        }

        return $response;
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
