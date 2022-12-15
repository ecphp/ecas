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
use EcPhp\CasLib\Configuration\PropertiesInterface;
use EcPhp\Ecas\EcasProperties;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class CasHelper
{
    public static function getHttpClientMock()
    {
        $callback = static function ($method, $url, $options) {
            $body = '';
            $info = [];

            switch ($url) {
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
                                    "proxies": [
                                        "http://app/proxyCallback.php"
                                    ]
                                }
                            }
                        }
                        EOF;

                    break;

                case 'http://local/cas/serviceValidate?service=service&ticket=authenticationLevel_feature_success':
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

                case 'http://local/cas/serviceValidate?service=service&ticket=authenticationLevel_high':
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

                case 'http://local/cas/serviceValidate?service=service&ticket=authenticationLevel_basic':
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
                                    "authenticationLevel": "HIGH",
                                    "proxyGrantingTicket": "pgtIou"
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
                        'allowed_parameters' => [
                            'service',
                            'custom',
                            'renew',
                            'gateway',
                        ],
                        'default_parameters' => [
                            'authenticationLevel' => 'MEDIUM',
                        ],
                    ],
                    'logout' => [
                        'path' => '/logout',
                        'allowed_parameters' => [
                            'service',
                            'custom',
                        ],
                    ],
                    'serviceValidate' => [
                        'path' => '/serviceValidate',
                        'allowed_parameters' => [
                            'ticket',
                            'service',
                            'custom',
                        ],
                        'default_parameters' => [
                            'format' => 'JSON',
                        ],
                    ],
                    'proxyValidate' => [
                        'path' => '/proxyValidate',
                        'allowed_parameters' => [
                            'ticket',
                            'service',
                            'custom',
                        ],
                        'default_parameters' => [
                            'format' => 'JSON',
                        ],
                    ],
                    'proxy' => [
                        'path' => '/proxy',
                        'allowed_parameters' => [
                            'targetService',
                            'pgt',
                        ],
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
