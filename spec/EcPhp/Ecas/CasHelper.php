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
use Error;
use Exception;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class CasHelper
{
    public static function getHttpClientMock()
    {
        $callback = static function ($method, $url, $options) {
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

                case 'http://local/cas/login/failure/init':
                    throw new Error('Test');

                    break;

                case 'http://local/cas/login/init':
                case 'http://local/cas/login/success/init':
                case 'http://local/cas/login/success/init?authenticationLevel=MEDIUM&format=JSON&service=http%3A%2F%2Ffoobar%2F':
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
                case 'http://local/cas/serviceValidate?ticket=ST-ticket&service=http%3A%2F%2Ffrom':
                case 'http://local/cas/serviceValidate?ticket=ST-ticket&service=http%3A%2F%2Flocal%2Fcas%2FserviceValidate%3Fservice%3Dservice':
                case 'http://local/cas/serviceValidate?ticket=PT-ticket&service=http%3A%2F%2Flocal%2Fcas%2FproxyValidate%3Fservice%3Dservice':
                case 'http://local/cas/serviceValidate?ticket=PT-ticket&service=http%3A%2F%2Ffrom':
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

                case 'http://local/cas/serviceValidate?service=service&ticket=ticket-failure':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationFailure": {}
                            }
                        }
                        EOF;
                    $body = <<< 'EOF'
                        <cas:serviceResponse xmlns:cas="http://www.yale.edu/tp/cas">
                         <cas:authenticationFailure>
                         </cas:authenticationFailure>
                        </cas:serviceResponse>
                        EOF;

                    break;

                case 'http://local/cas/proxyValidate?service=service&ticket=ticket':
                case 'http://local/cas/proxyValidate?ticket=PT-ticket&service=http%3A%2F%2Ffrom':
                case 'http://local/cas/proxyValidate?ticket=ST-ticket&service=http%3A%2F%2Ffrom':
                case 'http://local/cas/proxyValidate?service=http%3A%2F%2Flocal%2Fcas%2FproxyValidate%3Fservice%3Dservice&ticket=ticket':
                case 'http://local/cas/proxyValidate?service=http%3A%2F%2Flocal%2Fcas%2FproxyValidate%3Fservice%3Dservice%26renew%3Dtrue&ticket=ticket&renew=true':
                case 'http://local/cas/proxyValidate?service=http%3A%2F%2Flocal%2Fcas%2FserviceValidate%3Fservice%3Dservice&ticket=ticket':
                case 'http://local/cas/proxyValidate?service=http%3A%2F%2Flocal%2Fcas%2FserviceValidate%3Fservice%3Dservice%26renew%3Dtrue&ticket=ticket&renew=true':
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

                case 'http://local/cas/serviceValidate?format=JSON&service=service&ticket=authenticationLevel_basic':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationSuccess": {
                                    "user": "username",
                                    "authenticationLevel": "BASIC",
                                    "proxies": [
                                        "http://app/proxyCallback.php"
                                    ]
                                }
                            }
                        }
                        EOF;

                    break;

                case 'http://local/cas/serviceValidate?ticket=ST-ticket-pgt&service=http%3A%2F%2Ffrom':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationSuccess": {
                                    "user": "username",
                                    "proxyGrantingTicket": "pgtIou"
                                }
                            }
                        }
                        EOF;

                    break;

                case 'http://local/cas/serviceValidate?ticket=ST-ticket-pgt-pgtiou-not-found&service=http%3A%2F%2Ffrom':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationSuccess": {
                                    "user": "username",
                                    "proxyGrantingTicket": "unknownPgtIou"
                                }
                            }
                        }
                        EOF;

                    break;

                case 'http://local/cas/proxyValidate?ticket=ST-ticket-pgt-pgtiou-pgtid-null&service=http%3A%2F%2Ffrom':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationSuccess": {
                                    "user": "username",
                                    "proxyGrantingTicket": "pgtIouWithPgtIdNull"
                                }
                            }
                        }
                        EOF;

                    break;

                case 'http://local/cas/proxyValidate?service=service&ticket=ST-ticket-pgt':
                case 'http://local/cas/proxyValidate?ticket=ST-ticket-pgt&service=http%3A%2F%2Ffrom':
                case 'http://local/cas/proxyValidate?service=http%3A%2F%2Flocal%2Fcas%2FproxyValidate%3Fservice%3Dhttp%253A%252F%252Ffrom&ticket=PT-ticket-pgt':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationSuccess": {
                                    "user": "username",
                                    "proxyGrantingTicket": "pgtIou",
                                    "proxies": [
                                        "http://app/proxyCallback.php"
                                    ]
                                }
                            }
                        }
                        EOF;

                    break;

                case 'http://local/cas/serviceValidate?service=http%3A%2F%2Flocal%2Fcas%2FserviceValidate%3Fservice%3Dservice%26format%3DJSON&ticket=ticket&format=JSON':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationSuccess": {
                                    "user": "username"
                                }
                            }
                        }
                        EOF;

                    break;

                case 'http://local/cas/proxyValidate?service=http%3A%2F%2Ffrom&ticket=PT-ticket':
                    $body = <<< 'EOF'
                        {
                            "serviceResponse": {
                                "authenticationSuccess": {
                                    "user": "username",
                                    "proxyGrantingTicket": "pgtIou",
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
        $properties = self::getTestProperties()->all();

        $properties['protocol']['serviceValidate']['default_parameters']['pgtUrl'] = 'https://from/proxyCallback.php';

        return new EcasProperties(new CasProperties($properties));
    }
}
