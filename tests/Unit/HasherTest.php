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

declare(strict_types=1);

namespace Piwik\Plugins\ProtectTrackID\tests\Unit;

use PHPUnit\Framework\TestCase;
use Piwik\Plugins\ProtectTrackID\Hasher;
use Piwik\Plugins\ProtectTrackID\InvalidHasherValueException;
use Piwik\Plugins\ProtectTrackID\PluginSettings;

/**
 * @group ProtectTrackID
 * @group HasherTest
 * @group Plugins
 */
class HasherTest extends TestCase
{
    const BASE = 'ABCDEFGHIJKLMNOPijklmnopqrstuvxwyz12345';
    const SALT = 'd4768387-2f45-47cc-b581-7f66c5b724af';
    const LENGTH = 20;
    const ID_1_RAW = '1';
    const ID_1_HASEHD = '4jMymK3Eq1k21pxLOJlv';

    public function testEncode(): void
    {
        $hasher = new Hasher($this->getPluginSettings());
        $hashExpected = self::ID_1_HASEHD;
        $hashGot = $hasher->encode(self::ID_1_RAW);

        self::assertEquals($hashExpected, $hashGot);
    }

    public function testEncodeWithInvalidId(): void
    {
        $this->expectException(InvalidHasherValueException::class);

        $hasher = new Hasher($this->getPluginSettings());
        $hasher->encode('foo');
    }

    public function testDecode(): void
    {
        $hasher = new Hasher($this->getPluginSettings());
        $idExpected = self::ID_1_RAW;
        $idGot = $hasher->decode(self::ID_1_HASEHD);

        self::assertEquals($idExpected, $idGot);
    }

    public function testDecodeWithInvalidHash(): void
    {
        $this->expectException(InvalidHasherValueException::class);

        $hasher = new Hasher($this->getPluginSettings());
        $hasher->decode('foo');
    }

    private function getPluginSettings(): PluginSettings
    {
        return new PluginSettings(self::BASE, self::SALT, self::LENGTH);
    }
}
