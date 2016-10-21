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

use Piwik\API\Request;
use Piwik\Common;
use Exception;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\UrlHelper;

class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /**
     * Base string example
     *
     * @var string
     */
    private $base_example = 'ABCDEFGHIJKLMNOPijklmnopqrstuvxwyz12345';

    /**
     * Regex for validation string base
     *
     * @var string
     */
    private $base_regex = '/^[a-zA-Z0-9]+$/';

    /**
     * Base setting
     *
     * @var Setting
     */
    public $base;

    /**
     * Salt setting
     *
     * @var Setting
     */
    public $salt;

    /**
     * Length setting
     *
     * @var Setting
     */
    public $length;

    /**
     * @see Piwik\Settings\Plugin\SystemSettings
     */
    protected function init()
    {
        require(__DIR__.'/vendor/autoload.php');

        $this->base = $this->createBaseSetting();
        $this->salt = $this->createSaltSetting();
        $this->length = $this->createLengthSetting();
    }

    /**
     * Create base setting
     *
     * @return SystemSetting
     */
    private function createBaseSetting()
    {
        return $this->makeSetting('baseSetting', null, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Base string';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->introduction = 'Alphanumeric base string';
            $field->description = 'Enter a alphanumeric upcase and/or downcase. Example:  '.$this->base_example;
            $field->validate = function ($value) {
                if ($value && !preg_match($this->base_regex, $value)) {
                    throw new \Exception('Wrong input on Base string');
                }
            };
        });
    }

    /**
     * Create salt setting
     *
     * @return SystemSetting
     */
    private function createSaltSetting()
    {
        return $this->makeSetting('saltSetting', null, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Salt';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = ['size' => 80];
            $field->introduction = 'Salt string for hash siteId';
            $field->description = 'Enter with a big random string. Example: '.\Ramsey\Uuid\Uuid::uuid4();
        });
    }

    /**
     * Create length setting
     *
     * @return SystemSetting
     */
    private function createLengthSetting()
    {
        return $this->makeSetting('lengthSetting', null, FieldConfig::TYPE_INT, function (FieldConfig $field) {
            $field->title = 'Length';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->introduction = 'Hash string size';
            $field->description = 'Enter a length between 5 and 25. Example: 10';
            $field->validate = function ($value) {
                if ($value && ($value < 5 || $value > 25)) {
                    throw new \Exception('Wrong input on Length');
                }
            };
        });
    }
}
