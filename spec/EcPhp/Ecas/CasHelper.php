<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace spec\EcPhp\Ecas;

use EcPhp\CasLib\Configuration\Properties as CasProperties;
use EcPhp\CasLib\Contract\Configuration\PropertiesInterface;
use EcPhp\Ecas\EcasProperties;
use Exception;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CasHelper
{
    public static function getHttpClientMock(): HttpClientInterface
    {
        $callback = static function (string $method, string $url, array $options): ResponseInterface {
            $body = '';
            $info = [
                'response_headers' => [
                    'Content-Type' => 'application/json',
                ],
            ];

            switch ($url) {
                case 'http://local/cas/login/bad-structure/init':
                    $body = json_encode([
                        'foo' => 'bar',
                    ]);

                    break;

                case 'http://local/cas/login/init':
                case 'http://local/cas/login/success/init':
                    $body = json_encode([
                        'loginRequest' => [
                            'loginRequestSuccess' => [
                                'loginRequestId' => sprintf('ECAS_LR-%s', $options['body']),
                            ],
                        ],
                    ]);

                    break;

                case 'http://local/cas/serviceValidate?format=JSON&service=service&ticket=ticket':
                case 'http://local/cas/serviceValidate?service=service&ticket=ticket':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationSuccess": {
                                    "user": "username",
                                    "authenticationLevel": "MEDIUM"
                                }
                            }
                        }
                        EOF;

                    break;

                case 'http://local/cas/serviceValidate?format=JSON&service=service&ticket=authenticationLevel_feature_success':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationSuccess": {
                                    "user": "username",
                                    "authenticationLevel": "MEDIUM",
                                    "proxies": [
                                        "http://app/proxyCallback.php"
                                    ]
                                }
                            }
                        }
                        EOF;

                    break;

                case 'http://local/cas/serviceValidate?format=JSON&service=service&ticket=authenticationLevel_high':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationSuccess": {
                                    "user": "username",
                                    "authenticationLevel": "HIGH",
                                    "proxies": [
                                        "http://app/proxyCallback.php"
                                    ]
                                }
                            }
                        }
                        EOF;

                    break;

                default:
                    throw new Exception(sprintf('URL %s is not defined in the HTTP mock client.', $url));

                    break;
            }

            return new MockResponse($body, $info);
        };

        return new MockHttpClient($callback);
    }

    public static function getTestProperties(): PropertiesInterface
    {
        return new EcasProperties(
            new CasProperties([
                'base_url' => 'http://local/cas',
                'protocol' => [
                    'login' => [
                        'path' => '/login',
                        'default_parameters' => [
                            'authenticationLevel' => 'MEDIUM',
                        ],
                    ],
                    'logout' => [
                        'path' => '/logout',
                    ],
                    'serviceValidate' => [
                        'path' => '/serviceValidate',
                        'default_parameters' => [
                            'format' => 'XML',
                        ],
                    ],
                    'proxyValidate' => [
                        'path' => '/proxyValidate',
                        'default_parameters' => [
                            'format' => 'XML',
                        ],
                    ],
                    'proxy' => [
                        'path' => '/proxy',
                    ],
                ],
            ])
        );
    }

    public static function getTestPropertiesWithPgtUrl(): PropertiesInterface
    {
        $properties = self::getTestProperties()->jsonSerialize();

        $properties['protocol']['serviceValidate']['default_parameters']['pgtUrl'] = 'https://from/proxyCallback.php';

        return new EcasProperties(new CasProperties($properties));
    }
}
