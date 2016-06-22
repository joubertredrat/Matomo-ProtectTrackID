<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * ProtectTrackID Settings
 *
 * @copyright (c) 2016 Joubert RedRat
 * @author Joubert RedRat <eu+github@redrat.com.br>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @category Piwik_Plugins
 * @package ProtectTrackID
 */

namespace Piwik\Plugins\ProtectTrackID;

use Piwik\Piwik;

class ProtectTrackID extends \Piwik\Plugin
{
    /**
     * Base string for hash
     *
     * @var string
     */
    private $base = 'ABCDEFGHIJKLMNOPQRSTUVXWYZabcdefghijklmnopqrstuvxwyz1234567890';

    /**
     * Register event observers
     *
     * @return array
     */
    public function registerEvents()
    {
        return [
            'Tracker.Request.getIdSite' => 'hashId'
        ];
    }

    /**
     * Hash id site
     *
     * @param int $idSite
     * @param array $params
     * @return void
     */
    public function hashId(&$idSite, $params)
    {
        require(__DIR__.'/vendor/autoload.php');

        $Settings = new Settings('ProtectTrackID');

        $salt = $Settings->saltSetting->getValue();
        $lenght = $Settings->lenghtSetting->getValue();

        $Hashid = new Hashids\Hashids($salt, $lenght, $this->base);
        $idSite = $Hashid->encode($idSite);
    }

    /**
     * Unhash id site
     *
     * @param int $idSite
     * @param array $params
     * @return void
     */
    public function unhashId(&$idSite, $params)
    {
        require(__DIR__.'/vendor/autoload.php');

        $Settings = new Settings('ProtectTrackID');

        $salt = $Settings->saltSetting->getValue();
        $lenght = $Settings->lenghtSetting->getValue();

        $Hashid = new Hashids\Hashids($salt, $lenght, $this->base);
        $idSite = $Hashid->decode($idSite)[0];
    }

    /**
     * Verify if hash is valid
     *
     * @param string $hash
     * @return bool
     */
    public function validateHash($hash)
    {
        require(__DIR__.'/vendor/autoload.php');

        $Settings = new Settings('ProtectTrackID');

        $lenght = $Settings->lenghtSetting->getValue();

        $regex = '/^('.implode('|', str_split($this->base)).'){'.$lenght.'}$/';
        return (bool) preg_match($regex, $hash);
    }
}
