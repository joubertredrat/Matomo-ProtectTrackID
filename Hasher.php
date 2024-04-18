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

require_once(__DIR__ . '/vendor/autoload.php');

use Hashids\Hashids;

class Hasher
{
    private $hashids;

    public function __construct(PluginSettings $settings)
    {
        $this->hashids = new Hashids($settings->salt, $settings->length, $settings->base);
    }

    public function encode(string $value): string
    {
        if (!IdSite::isValid($value)) {
            throw InvalidHasherValueException::handleEncode($value);
        }

        return $this
            ->hashids
            ->encode($value)
        ;
    }

    public function decode(string $value): int
    {
        $ids = $this
            ->hashids
            ->decode($value)
        ;

        if (count($ids) !== 1) {
            throw InvalidHasherValueException::handleDecode($value);
        }

        if (!IdSite::isValid($ids[0])) {
            throw InvalidHasherValueException::handleDecode($value);
        }

        return $ids[0];
    }
}
