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
use Piwik\Plugins\ProtectTrackID\Hasher;
use Piwik\Plugins\ProtectTrackID\PluginSettings;

/**
 * @group ProtectTrackID
 * @group HasherTest
 * @group Plugins
 */
class HasherTest extends TestCase
{
    const ID_1_RAW = '1';
    const ID_1_HASEHD = '4jMymK3Eq1k21pxLOJlv';

    public function testEncode(): void
    {
        $pluginSettings = new PluginSettings(
            'ABCDEFGHIJKLMNOPijklmnopqrstuvxwyz12345',
            'd4768387-2f45-47cc-b581-7f66c5b724af',
            20
        );

        $hasher = new Hasher($pluginSettings);
        $hashExpected = self::ID_1_HASEHD;
        $hashGot = $hasher->encode(self::ID_1_RAW);

        self::assertEquals($hashExpected, $hashGot);
    }

    public function testDecode(): void
    {
        $pluginSettings = new PluginSettings(
            'ABCDEFGHIJKLMNOPijklmnopqrstuvxwyz12345',
            'd4768387-2f45-47cc-b581-7f66c5b724af',
            20
        );

        $hasher = new Hasher($pluginSettings);
        $idExpected = self::ID_1_RAW;
        $idGot = $hasher->decode(self::ID_1_HASEHD);

        self::assertEquals($idExpected, $idGot);
    }
}
