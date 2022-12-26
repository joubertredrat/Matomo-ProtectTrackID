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

namespace Piwik\Plugins\ProtectTrackID;

use Piwik\Plugin;

class ProtectTrackID extends Plugin
{
    public function registerEvents(): array
    {
        return [
            'Tracker.getJavascriptCode' => 'encodeIdJavaScript',
            'SitesManager.getImageTrackingCode' => 'encodeIdImage',
            'Tracker.Request.getIdSite' => 'decodeId',
        ];
    }

    public function encodeIdJavaScript(&$codeImpl, $parameters): void
    {
        $settings = PluginSettings::createFromSettings();
        $hasher = new Hasher($settings);

        $codeImpl['idSite'] = $hasher->encode($codeImpl['idSite']);
    }

    public function encodeIdImage(&$piwikUrl, &$urlParams): void
    {
        $settings = PluginSettings::createFromSettings();
        $hasher = new Hasher($settings);

        $urlParams['idsite'] = $hasher->encode($urlParams['idsite']);
    }

    public function decodeId(&$idSite, $params): void
    {
        $settings = PluginSettings::createFromSettings();

        if (!$this->isValidHash($settings, $params['idsite'])) {
            return;
        }

        $hasher = new Hasher($settings);
        $idSite = $hasher->decode($params['idsite']);
    }

    public function isValidHash(PluginSettings $settings, string $hash): bool
    {
        if (!$settings->hasValidValues()) {
            return false;
        }

        $regex = sprintf(
            '/^(%s){%s}$/',
            implode('|', str_split($settings->base)),
            $settings->length,
        );

        return (bool) preg_match($regex, $hash);
    }
}
