<?php

/**
 * Matomo - Open source web analytics
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * ProtectTrackID Settings
 *
 * @copyright (c) 2016 Joubert RedRat
 * @author Joubert RedRat <eu+matomo@redrat.com.br>
 * @license MIT
 * @category Matomo_Plugins
 * @package ProtectTrackID
 */

namespace Piwik\Plugins\ProtectTrackID;

use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\Settings\Plugin\SystemSetting;
use Piwik\Settings\Plugin\SystemSettings as MatomoPluginSystemSettings;
use Ramsey\Uuid\Uuid;

class SystemSettings extends MatomoPluginSystemSettings
{
    public const BASE_EXAMPLE = 'ABCDEFGHIJKLMNOPijklmnopqrstuvxwyz12345';

    public Setting $base;
    public Setting $salt;
    public Setting $length;

    protected function init(): void
    {
        require_once(__DIR__ . '/vendor/autoload.php');

        $this->base = $this->createBaseSetting();
        $this->salt = $this->createSaltSetting();
        $this->length = $this->createLengthSetting();
    }

    private function createBaseSetting(): SystemSetting
    {
        return $this->makeSetting('baseSetting', null, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Base string';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->introduction = 'Alphanumeric base string';
            $field->description = sprintf(
                'Enter a alphanumeric upcase and/or downcase, symbols is not allowed. Example: %s',
                self::BASE_EXAMPLE,
            );
            $field->validate = function (string $value) {
                if ($value && !PluginSettings::isValidBase($value)) {
                    throw InvalidSettingValueException::handleBase($value);
                }
            };
        });
    }

    private function createSaltSetting(): SystemSetting
    {
        return $this->makeSetting('saltSetting', null, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Salt';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = ['size' => 80];
            $field->introduction = 'Salt string for hash siteId';
            $field->description = 'Enter with a big random string. Example: ' . Uuid::uuid4();
        });
    }

    private function createLengthSetting(): SystemSetting
    {
        return $this->makeSetting('lengthSetting', null, FieldConfig::TYPE_INT, function (FieldConfig $field) {
            $field->title = 'Length';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->introduction = 'Hash string size';
            $field->description = sprintf(
                'Enter a length between %d and %d. Example: 15',
                PluginSettings::MIN_LENGTH,
                PluginSettings::MAX_LENGTH,
            );
            $field->validate = function (string $value) {
                if ($value && !PluginSettings::isValidLenght((int) $value)) {
                    throw InvalidSettingValueException::handleLenght(
                        PluginSettings::MIN_LENGTH,
                        PluginSettings::MAX_LENGTH,
                        (int) $value,
                    );
                }
            };
        });
    }
}
