<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Introspection;

use EcPhp\CasLib\Introspection\Contract\IntrospectionInterface;
use EcPhp\CasLib\Introspection\Contract\IntrospectorInterface;
use EcPhp\CasLib\Introspection\ServiceValidate;
use Psr\Http\Message\ResponseInterface;

use function in_array;

final class EcasIntrospector implements IntrospectorInterface
{
    /**
     * @var \EcPhp\CasLib\Introspection\Contract\IntrospectorInterface
     */
    private $introspector;

    public function __construct(IntrospectorInterface $introspector)
    {
        $this->introspector = $introspector;
    }

    public function detect(ResponseInterface $response): IntrospectionInterface
    {
        $introspect = $this->introspector->detect($response);

        if ($introspect instanceof ServiceValidate) {
            return $introspect
                ->withParsedResponse(
                    $this->normalizeUserData($introspect->getParsedResponse())
                );
        }

        return $introspect;
    }

    public function parse(ResponseInterface $response, string $format = 'XML'): array
    {
        return $this->introspector->parse($response, $format);
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
