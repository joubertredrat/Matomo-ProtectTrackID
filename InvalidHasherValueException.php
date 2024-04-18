<?php

/**
 * Matomo - Open source web analytics
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @copyright (c) 2024 Joubert RedRat
 * @author Joubert RedRat <eu+matomo@redrat.com.br>
 * @license MIT
 * @category Matomo_Plugins
 * @package ProtectTrackID
 */

declare(strict_types=1);

namespace Piwik\Plugins\ProtectTrackID;

use InvalidArgumentException;

class InvalidHasherValueException extends InvalidArgumentException
{
    public static function handleEncode(string $value): self
    {
        return new self(sprintf(
            'Invalid value for Hasher encode, expected id site integer, got %1$s.',
            $value
        ));
    }

    public static function handleDecode(string $value): self
    {
        return new self(sprintf(
            'Invalid value for Hasher decode, expected valid hash, got %1$s.',
            $value
        ));
    }
}
