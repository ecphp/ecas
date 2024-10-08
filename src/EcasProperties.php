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
use EcPhp\CasLib\Contract\Configuration\PropertiesInterface;
use InvalidArgumentException;

use function array_key_exists;
use function is_string;
use function sprintf;

final class EcasProperties implements PropertiesInterface
{
    public const AUTHENTICATION_LEVEL_BASIC = 'BASIC';

    public const AUTHENTICATION_LEVEL_HIGH = 'HIGH';

    public const AUTHENTICATION_LEVEL_MEDIUM = 'MEDIUM';

    public const AUTHENTICATION_LEVELS = [
        self::AUTHENTICATION_LEVEL_HIGH => 7,
        self::AUTHENTICATION_LEVEL_MEDIUM => 3,
        self::AUTHENTICATION_LEVEL_BASIC => 1,
    ];

    private PropertiesInterface $properties;

    public function __construct(PropertiesInterface $casProperties)
    {
        /** @var array $properties */
        $properties = $casProperties->jsonSerialize();

        $properties['protocol']['serviceValidate']['default_parameters']['format'] = 'JSON';
        $properties['protocol']['proxyValidate']['default_parameters']['format'] = 'JSON';
        $properties['protocol']['login']['default_parameters']['format'] = 'JSON';
        $properties['protocol']['login']['default_parameters']['authenticationLevel'] = $properties['protocol']['login']['default_parameters']['authenticationLevel'] ?? self::AUTHENTICATION_LEVEL_BASIC;

        if (false === is_string($properties['protocol']['login']['default_parameters']['authenticationLevel'])) {
            throw new InvalidArgumentException(sprintf('The "%s" property must be a string. Available values are: %s', 'authenticationLevel', implode(', ', array_keys(self::AUTHENTICATION_LEVELS))));
        }

        if (false === array_key_exists($properties['protocol']['login']['default_parameters']['authenticationLevel'], self::AUTHENTICATION_LEVELS)) {
            throw new InvalidArgumentException(sprintf('The "%s" property is invalid. Available values are: %s', 'authenticationLevel', implode(', ', array_keys(self::AUTHENTICATION_LEVELS))));
        }

        $this->properties = new Properties($properties);
    }

    public function jsonSerialize(): mixed
    {
        return $this->properties->jsonSerialize();
    }
}
