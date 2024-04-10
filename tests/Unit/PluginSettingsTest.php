<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @copyright (c) 2024 Joubert RedRat
 * @author Joubert RedRat <eu+matomo@redrat.com.br>
 * @license MIT
 * @category Matomo_Plugins
 * @package ProtectTrackID
 */

namespace Piwik\Plugins\ProtectTrackID\tests\Unit;

use PHPUnit\Framework\TestCase;
use Piwik\Plugins\ProtectTrackID\PluginSettings;

/**
 * @group ProtectTrackID
 * @group PluginSettingsTest
 * @group Plugins
 */
class PluginSettingsTest extends TestCase
{
    public function testHasValidValues(): void
    {
        $pluginSettings = new PluginSettings(
            'ABCDEFGHIJKLMNOPijklmnopqrstuvxwyz12345',
            'd4768387-2f45-47cc-b581-7f66c5b724af',
            20
        );

        self::assertTrue($pluginSettings->hasValidValues());
    }

    public function testHasNotValidValuesByBase(): void
    {
        $pluginSettings = new PluginSettings(
            null,
            'd4768387-2f45-47cc-b581-7f66c5b724af',
            20
        );

        self::assertFalse($pluginSettings->hasValidValues());
    }

    public function testHasNotValidValuesBySalt(): void
    {
        $pluginSettings = new PluginSettings(
            'ABCDEFGHIJKLMNOPijklmnopqrstuvxwyz12345',
            null,
            20
        );

        self::assertFalse($pluginSettings->hasValidValues());
    }

    public function testHasNotValidValuesByLength(): void
    {
        $pluginSettings = new PluginSettings(
            'ABCDEFGHIJKLMNOPijklmnopqrstuvxwyz12345',
            'd4768387-2f45-47cc-b581-7f66c5b724af',
            null
        );

        self::assertFalse($pluginSettings->hasValidValues());
    }

    public function testIsValidBase(): void
    {
        self::assertTrue(PluginSettings::isValidBase('ABCDEFGHIJKLMNOPijklmnopqrstuvxwyz12345'));
    }

    public function testIsNotValidBase(): void
    {
        self::assertFalse(PluginSettings::isValidBase('ABCDEFGHIJKLMNO$Pijklm%nop#qrs@tu&vxwyz12345'));
    }

    public function testIsValidLenght(): void
    {
        self::assertTrue(PluginSettings::isValidLenght(20));
    }

    public function testIsNotValidLenght(): void
    {
        self::assertFalse(PluginSettings::isValidLenght(2));
    }
}
