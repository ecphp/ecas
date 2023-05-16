<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace spec\EcPhp\Ecas;

use EcPhp\CasLib\Configuration\Properties;
use EcPhp\Ecas\EcasProperties;
use PhpSpec\ObjectBehavior;

class EcasPropertiesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(EcasProperties::class);

        $this
            ->jsonSerialize()
            ->shouldReturn(
                [
                    'foo' => 'bar',
                    'protocol' => [
                        'serviceValidate' => [
                            'default_parameters' => [
                                'format' => 'JSON',
                            ],
                        ],
                        'proxyValidate' => [
                            'default_parameters' => [
                                'format' => 'JSON',
                            ],
                        ],
                        'login' => [
                            'default_parameters' => [
                                'format' => 'JSON',
                                'authenticationLevel' => 'BASIC',
                            ],
                        ],
                    ],
                ]
            );
    }

    public function let()
    {
        $this
            ->beConstructedWith(new EcasProperties(new Properties(['foo' => 'bar'])));
    }
}
