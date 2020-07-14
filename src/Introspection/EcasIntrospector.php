<?php

declare(strict_types=1);

namespace EcPhp\Ecas\Introspection;

use EcPhp\CasLib\Introspection\Contract\IntrospectionInterface;
use EcPhp\CasLib\Introspection\Contract\IntrospectorInterface;
use EcPhp\CasLib\Introspection\ServiceValidate;
use Psr\Http\Message\ResponseInterface;

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

    /**
     * {@inheritdoc}
     */
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
        $storage = [];
        $rootAttributes = ['user', 'proxyGrantingTicket', 'proxies'];
        $data = $data['serviceResponse']['authenticationSuccess'];

        foreach ($rootAttributes as $rootAttribute) {
            $storage[$rootAttribute] = $data[$rootAttribute] ?? null;
        }
        $storage['attributes'] = array_diff_key($data, array_flip($rootAttributes));

        return [
            'serviceResponse' => [
                'authenticationSuccess' => array_filter($storage) + ['attributes' => []],
            ],
        ];
    }
}
