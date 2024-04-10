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
use Piwik\Plugins\ProtectTrackID\InvalidSettingValueException;

/**
 * @group ProtectTrackID
 * @group InvalidSettingValueExceptionTest
 * @group Plugins
 */
class InvalidSettingValueExceptionTest extends TestCase
{
    public function testHandleBase(): void
    {
        $this->expectException(InvalidSettingValueException::class);
        $this->expectExceptionMessage('Invalid value on base, was filled foo.');

        throw InvalidSettingValueException::handleBase('foo');
    }

    public function testHandleSalt(): void
    {
        $this->expectException(InvalidSettingValueException::class);
        $this->expectExceptionMessage('Invalid value on salt, was filled foo.');

        throw InvalidSettingValueException::handleSalt('foo');
    }

    public function testHandleLenght(): void
    {
        $this->expectException(InvalidSettingValueException::class);
        $this->expectExceptionMessage('Invalid value on length, expected between 5 and 25, was filled 30.');

        throw InvalidSettingValueException::handleLenght(5, 25, 30);
    }
}
