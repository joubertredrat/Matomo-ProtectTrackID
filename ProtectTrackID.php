<?php
/**
 * Matomo - Open source web analytics
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * ProtectTrackID Main class, responsible for hash and unhash idSite
 *
 * @copyright (c) 2016 Joubert RedRat
 * @author Joubert RedRat <eu+github@redrat.com.br>
 * @license MIT
 * @category Matomo_Plugins
 * @package ProtectTrackID
 */

namespace Piwik\Plugins\ProtectTrackID;

use Piwik\Container\StaticContainer;

class ProtectTrackID extends \Piwik\Plugin
{
    /**
     * Register event observers
     *
     * @return array
     */
    public function registerEvents()
    {
        return [
            'Tracker.getJavascriptCode' => 'hashIdJavaScript',
            'SitesManager.getImageTrackingCode' => 'hashIdImage',
            'Tracker.Request.getIdSite' => 'unhashId'
        ];
    }

    /**
     * Get plugin settings
     *
     * @return array
     */
    private function getSettings()
    {
        $settings = StaticContainer::get('Piwik\Plugins\ProtectTrackID\SystemSettings');

        return [
            'base' => $settings->base->getValue(),
            'salt' => $settings->salt->getValue(),
            'length' => $settings->length->getValue()
        ];
    }

    /**
     * Creates a hash from a integer id
     *
     * @param int $idSite
     * @return int|string
     */
    private function hashId($idSite)
    {
        extract($this->getSettings());

        if (is_null($base) || empty($base) ||
            is_null($salt) || empty($salt) ||
            is_null($length) || empty($length)
        ) {
            return $idSite;
        }

        require_once(__DIR__.'/vendor/autoload.php');

        $Hashid = new \Hashids\Hashids($salt, $length, $base);
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

            extract($this->getSettings());

            $Hashid = new \Hashids\Hashids($salt, $length, $base);
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
        extract($this->getSettings());

        if (is_null($base) || empty($base) ||
            is_null($salt) || empty($salt) ||
            is_null($length) || empty($length)
        ) {
            return false;
        }

        $regex = '/^('.implode('|', str_split($base)).'){'.$length.'}$/';
        return (bool) preg_match($regex, $hash);
    }
}
