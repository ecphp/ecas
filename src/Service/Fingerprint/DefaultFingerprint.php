<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\Ecas\Service\Fingerprint;

final class DefaultFingerprint implements Fingerprint
{
    public function generate(): string
    {
        return random_bytes(21);
    }
}
