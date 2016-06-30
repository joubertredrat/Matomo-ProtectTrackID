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
use Piwik\Settings\SystemSetting;

class Settings extends \Piwik\Plugin\Settings
{
    /**
     * Base string example
     *
     * @var string
     */
    private $base_example = 'ABCDEFGHIJKLMNOPQRSTUVXWYZabcdefghijklmnopqrstuvxwyz1234567890';

    /**
     * Regex for validation string base
     *
     * @var string
     */
    private $base_regex = '/^[a-zA-Z0-9]+$/';

    /**
     * @see \Piwik\Plugin\Settings::init()
     */
    protected function init()
    {
        require(__DIR__.'/vendor/autoload.php');
        $this->setIntroduction(Piwik::translate('ProtectTrackID_SettingsDescription'));

        $this->createBaseSetting();
        $this->createSaltSetting();
        $this->createLenghtSetting();
    }

    /**
     * Create base setting
     *
     * @return void
     */
    private function createBaseSetting()
    {
        $this->baseSetting = new SystemSetting('baseSetting', Piwik::translate('ProtectTrackID_BaseLabel'));
        $this->baseSetting->type = static::TYPE_STRING;
        $this->baseSetting->uiControlAttributes = ['size' => 80];
        $this->baseSetting->description = Piwik::translate('ProtectTrackID_BaseDescription');
        $this->baseSetting->inlineHelp = Piwik::translate('ProtectTrackID_BaseHelp').' '.$this->base_example;
        $this->baseSetting->validate = function ($value, $setting) {
            if ($value && !preg_match($this->base_regex, $value)) {
                throw new \Exception(Piwik::translate('ProtectTrackID_ErrMsgWrongValue'));
            }
        };

        $this->addSetting($this->baseSetting);
    }

    /**
     * Create salt setting
     *
     * @return void
     */
    private function createSaltSetting()
    {
        $this->saltSetting = new SystemSetting('saltSetting', Piwik::translate('ProtectTrackID_SaltLabel'));
        $this->saltSetting->type = static::TYPE_STRING;
        $this->saltSetting->uiControlAttributes = ['size' => 80];
        $this->saltSetting->description = Piwik::translate('ProtectTrackID_SaltDescription');
        $this->saltSetting->inlineHelp = Piwik::translate('ProtectTrackID_SaltHelp').' '.\Ramsey\Uuid\Uuid::uuid4();

        $this->addSetting($this->saltSetting);
    }

    /**
     * Create length setting
     *
     * @return void
     */
    private function createLenghtSetting()
    {
        $this->lenghtSetting = new SystemSetting('lenghtSetting', Piwik::translate('ProtectTrackID_LenghtLabel'));
        $this->lenghtSetting->type = static::TYPE_INT;
        $this->lenghtSetting->description = Piwik::translate('ProtectTrackID_LenghtDescription');
        $this->lenghtSetting->inlineHelp = Piwik::translate('ProtectTrackID_LenghtHelp').' 9';
        $this->lenghtSetting->validate = function ($value, $setting) {
            if ($value && ($value < 5 || $value > 25)) {
                    throw new \Exception(Piwik::translate('ProtectTrackID_ErrMsgWrongValue'));
            }
        };

        $this->addSetting($this->lenghtSetting);
    }
}
