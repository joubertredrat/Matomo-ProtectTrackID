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
use Piwik\Plugins\ProtectTrackID\IdSite;

/**
 * @group ProtectTrackID
 * @group IdSiteTest
 * @group Plugins
 */
class IdSiteTest extends TestCase
{
    public function testIsValidString(): void
    {
        self::assertTrue(IdSite::isValid('2'));
    }

    public function testIsValidInt(): void
    {
        self::assertTrue(IdSite::isValid(2));
    }

    public function testIsNotValidStringFloat(): void
    {
        self::assertFalse(IdSite::isValid('2.1'));
    }

    public function testIsNotValidString(): void
    {
        self::assertFalse(IdSite::isValid('foo'));
    }

    public function testIsNotValidNull(): void
    {
        self::assertFalse(IdSite::isValid(null));
    }

    public function testIsNotValidFloat(): void
    {
        self::assertFalse(IdSite::isValid(2.1));
    }

    public function testIsNotValidBool(): void
    {
        self::assertFalse(IdSite::isValid(false));
    }
}
