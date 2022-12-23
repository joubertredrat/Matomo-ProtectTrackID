<?php

/**
 * Matomo - Open source web analytics
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * API Main class, responsible for plugin provide API methods
 *
 * @copyright (c) 2022 Joubert RedRat
 * @author Joubert RedRat <eu+matomo@redrat.com.br>
 * @license MIT
 * @category Matomo_Plugins
 * @package ProtectTrackID
 */

 declare(strict_types=1);

 namespace Piwik\Plugins\ProtectTrackID;

 use Piwik\Piwik;
 use Piwik\Plugin\API as PluginAPI;

/**
 * API for plugin ProtectTrackID
 *
 * @method static \Piwik\Plugins\ProtectTrackID\API getInstance()
 */
class API extends PluginAPI
{
    public function getHashedId(int $idSite): string
    {
        Piwik::checkUserHasSomeViewAccess();

        $settings = PluginSettings::createFromSettings();
        if (!$settings->hasValidValues()) {
            return $idSite;
        }

        $hasher = new Hasher($settings);
        return $hasher->encode((string) $idSite);
    }
}
