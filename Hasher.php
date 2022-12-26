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

use Hashids\Hashids;

class Hasher
{
    private Hashids $hashids;

    public function __construct(PluginSettings $settings)
    {
        require_once(__DIR__ . '/vendor/autoload.php');
        $this->hashids = new Hashids($settings->salt, $settings->length, $settings->base);
    }

    public function encode(string $value): string
    {
        return $this
            ->hashids
            ->encode($value)
        ;
    }

    public function decode(string $value): int
    {
        return $this
            ->hashids
            ->decode($value)[0]
        ;
    }
}
