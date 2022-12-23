<?php

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

declare(strict_types=1);

namespace Piwik\Plugins\ProtectTrackID;

use Piwik\Container\StaticContainer;

class PluginSettings
{
    public const BASE_REGEX = '/^[a-zA-Z0-9]+$/';
    public const MIN_LENGTH = 5;
    public const MAX_LENGTH = 25;

    public string $base;
    public string $salt;
    public int $length;

    public function __construct(string $base, string $salt, int $length)
    {
        $this->base = $base;
        $this->salt = $salt;
        $this->length = $length;
    }

    public function hasValidValues(): bool
    {
        if (is_null($this->base) || empty($this->base)) {
            return false;
        }
        if (is_null($this->salt) || empty($this->salt)) {
            return false;
        }
        if (is_null($this->length) || empty($this->length)) {
            return false;
        }

        return true;
    }

    public static function isValidBase(string $base): bool
    {
        return (bool) preg_match(self::BASE_REGEX, $base);
    }

    public static function isValidLenght(int $length): bool
    {
        return $length >= self::MIN_LENGTH && $length <= self::MAX_LENGTH;
    }

    public static function createFromSettings(): self
    {
        $settings = StaticContainer::get(SystemSettings::class);

        return new self(
            $settings->base->getValue(),
            $settings->salt->getValue(),
            $settings->length->getValue(),
        );
    }
}
