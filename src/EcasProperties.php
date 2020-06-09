<?php

declare(strict_types=1);

namespace EcPhp\Ecas;

use EcPhp\CasLib\Configuration\Properties;
use EcPhp\CasLib\Configuration\PropertiesInterface;

/**
 * Class Ecas.
 */
final class EcasProperties implements PropertiesInterface
{
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

        $this->cas = new Properties($properties);
    }

    /**
     * {@inheritdoc}
     */
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
