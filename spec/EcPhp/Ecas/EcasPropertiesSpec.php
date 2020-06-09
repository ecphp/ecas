<?php

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
            ->all()
            ->shouldReturn(
                [
                    'foo' => 'bar',
                    'protocol' => [
                        'serviceValidate' => [
                            'allowed_parameters' => [
                                0 => 'userDetails',
                            ],
                            'default_parameters' => [
                                'format' => 'XML',
                            ],
                        ],
                        'proxyValidate' => [
                            'allowed_parameters' => [
                                0 => 'userDetails',
                            ],
                            'default_parameters' => [
                                'format' => 'XML',
                            ],
                        ],
                    ],
                ]
            );
    }

    public function let()
    {
        $properties = [
            'foo' => 'bar',
        ];

        $this
            ->beConstructedWith(new Properties($properties));
    }
}
