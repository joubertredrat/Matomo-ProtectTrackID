<?php

/**
 * Matomo - Open source web analytics
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @copyright (c) 2016 Joubert RedRat
 * @author Joubert RedRat <eu+matomo@redrat.com.br>
 * @license MIT
 * @category Matomo_Plugins
 * @package ProtectTrackID
 */

declare(strict_types=1);

namespace Piwik\Plugins\ProtectTrackID;

use InvalidArgumentException;

class InvalidSettingValueException extends InvalidArgumentException
{
    public static function handleBase(string $baseGot): self
    {
        return new self(sprintf(
            'Invalid value on base, was filled %1$s.',
            $baseGot,
        ));
    }

    public static function handleSalt(string $saltGot): self
    {
        return new self(sprintf(
            'Invalid value on salt, was filled %1$s.',
            $saltGot,
        ));
    }

    public static function handleLenght(int $lengthMinExpected, int $lengthMaxExpected, int $lengthGot): self
    {
        return new self(sprintf(
            'Invalid value on length, expected between %1$d and %2$d, was filled %3$d.',
            $lengthMinExpected,
            $lengthMaxExpected,
            $lengthGot,
        ));
    }
}
