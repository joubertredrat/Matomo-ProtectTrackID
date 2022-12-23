<?php

declare(strict_types=1);

/**
 * Matomo - Open source web analytics
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * ProtectTrackID Settings
 *
 * @copyright (c) 2016 Joubert RedRat
 * @author Joubert RedRat <eu+matomo@redrat.com.br>
 * @license MIT
 * @category Matomo_Plugins
 * @package ProtectTrackID
 */

namespace Piwik\Plugins\ProtectTrackID;

use InvalidArgumentException;

class InvalidSettingValueException extends InvalidArgumentException
{
    public static function handleBase(string $baseGot): self
    {
        return new self(sprintf(
            'Invalid value on Base, was filled %s.',
            $baseGot,
        ));
    }

    public static function handleLenght(int $lengthMinExpected, int $lengthMaxExpected, int $lengthGot): self
    {
        return new self(sprintf(
            'Invalid value on Length, expected between %d and %d, was filled %d.',
            $lengthMinExpected,
            $lengthMaxExpected,
            $lengthGot,
        ));
    }
}
