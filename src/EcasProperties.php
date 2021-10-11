<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas;

use EcPhp\CasLib\Configuration\Properties;
use EcPhp\CasLib\Configuration\PropertiesInterface;

// phpcs:disable Generic.Files.LineLength.TooLong

final class EcasProperties implements PropertiesInterface
{
    private const AUTHENTICATION_LEVELS = [
        'BASIC',
        'MEDIUM',
        'HIGH',
    ];

    /**
     * @var \EcPhp\CasLib\Configuration\PropertiesInterface
     */
    private $cas;

    public function __construct(PropertiesInterface $casProperties)
    {
        $properties = $casProperties->all();

        $properties['protocol']['serviceValidate']['allowed_parameters'][] = 'userDetails';
        $properties['protocol']['proxyValidate']['allowed_parameters'][] = 'userDetails';
        $properties['protocol']['serviceValidate']['default_parameters']['format'] = 'XML';
        $properties['protocol']['proxyValidate']['default_parameters']['format'] = 'XML';
        $properties['protocol']['login']['allowed_parameters'][] = 'authenticationLevel';
        $properties['protocol']['login']['default_parameters']['authenticationLevel'] = $properties['protocol']['login']['default_parameters']['authenticationLevel'] ?? self::AUTHENTICATION_LEVELS;

        $this->cas = new Properties($properties);
    }

    public function all(): array
    {
        return $this->cas->all();
    }

    /**
     * @param mixed $offset
     */
    public function offsetExists($offset)
    {
        return $this->cas->offsetExists($offset);
    }

    /**
     * @param mixed $offset
     */
    public function offsetGet($offset)
    {
        return $this->cas->offsetGet($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->cas->offsetSet($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->cas->offsetUnset($offset);
    }
}
