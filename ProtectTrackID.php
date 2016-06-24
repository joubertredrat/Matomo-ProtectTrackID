<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * ProtectTrackID Main class, responsible for hash and unhash idSite
 *
 * @copyright (c) 2016 Joubert RedRat
 * @author Joubert RedRat <eu+github@redrat.com.br>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @category Piwik_Plugins
 * @package ProtectTrackID
 */

namespace Piwik\Plugins\ProtectTrackID;

class ProtectTrackID extends \Piwik\Plugin
{
    /**
     * Base string for hash
     *
     * @var string
     * @todo In future will be a Setting on Plugin Options
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
            'Piwik.getJavascriptCode' => 'hashIdJavaScript',
            'SitesManager.getImageTrackingCode' => 'hashIdImage',
            'Tracker.Request.getIdSite' => 'unhashId'
        ];
    }

    /**
     * Creates a hash from a integer id
     *
     * @param int $idSite
     * @return string
     */
    private function hashId($idSite)
    {
        require_once(__DIR__.'/vendor/autoload.php');

        $Settings = new Settings('ProtectTrackID');
        $salt = $Settings->saltSetting->getValue();
        $lenght = $Settings->lenghtSetting->getValue();

        $Hashid = new \Hashids\Hashids($salt, $lenght, $this->base);
        return $Hashid->encode($idSite);
    }

    /**
     * Hash id site for JavaScript Tracking Code
     *
     * @param array &$codeImpl
     * @param array $parameters
     * @return void
     */
    public function hashIdJavaScript(&$codeImpl, $parameters)
    {
        $codeImpl['idSite'] = $this->hashId($codeImpl['idSite']);
    }

    /**
     * Hash id site for Image Tracking Link
     *
     * @param array &$piwikUrl
     * @param array &$urlParams
     * @return void
     */
    public function hashIdImage(&$piwikUrl, &$urlParams)
    {
        $urlParams['idsite'] = $this->hashId($urlParams['idsite']);
    }

    /**
     * Unhash id site
     *
     * @param int &$idSite
     * @param array $params
     * @return void
     */
    public function unhashId(&$idSite, $params)
    {
        if ($this->validateHash($params['idsite'])) {
            require_once(__DIR__.'/vendor/autoload.php');

            $Settings = new Settings('ProtectTrackID');

            $salt = $Settings->saltSetting->getValue();
            $lenght = $Settings->lenghtSetting->getValue();

            $Hashid = new \Hashids\Hashids($salt, $lenght, $this->base);
            $idSite = $Hashid->decode($params['idsite'])[0];
        }
    }

    /**
     * Verify if hash is valid from settings
     *
     * @param string $hash
     * @return bool
     */
    public function validateHash($hash)
    {
        $Settings = new Settings('ProtectTrackID');

        $lenght = $Settings->lenghtSetting->getValue();

        $regex = '/^('.implode('|', str_split($this->base)).'){'.$lenght.'}$/';
        return (bool) preg_match($regex, $hash);
    }
}
