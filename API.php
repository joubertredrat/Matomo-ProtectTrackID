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
 * @author Joubert RedRat <eu+github@redrat.com.br>
 * @license MIT
 * @category Matomo_Plugins
 * @package ProtectTrackID
 */

 namespace Piwik\Plugins\ProtectTrackID;

 use Hashids\Hashids;
 use Piwik\Container\StaticContainer;
 use Piwik\Piwik;
 use Piwik\Plugin\API as PluginAPI;

/**
 * API for plugin ProtectTrackID
 *
 * @method static \Piwik\Plugins\ProtectTrackID\API getInstance()
 */
class API extends PluginAPI
{
    public function getHashedID(int $idSite): string
    {
        Piwik::checkUserHasSomeViewAccess();

        $settings = StaticContainer::get(SystemSettings::class);
        $base = $settings->base->getValue();
        $salt = $settings->salt->getValue();
        $length = $settings->length->getValue();

        if (is_null($base) || empty($base) ||
            is_null($salt) || empty($salt) ||
            is_null($length) || empty($length)
        ) {
            return $idSite;
        }

        require_once(__DIR__ . '/vendor/autoload.php');

        $hashid = new Hashids($salt, $length, $base);
        return $hashid->encode($idSite);
    }
}
