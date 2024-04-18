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
use Piwik\Plugins\ProtectTrackID\InvalidHasherValueException;

/**
 * @group ProtectTrackID
 * @group InvalidHasherValueExceptionTest
 * @group Plugins
 */

class InvalidHasherValueExceptionTest extends TestCase
{
    public function testHandleEncode(): void
    {
        $this->expectException(InvalidHasherValueException::class);
        $this->expectExceptionMessage('Invalid value for Hasher encode, expected id site integer, got foo.');

        throw InvalidHasherValueException::handleEncode('foo');
    }

    public function testHandleDecode(): void
    {
        $this->expectException(InvalidHasherValueException::class);
        $this->expectExceptionMessage('Invalid value for Hasher decode, expected valid hash, got foo.');

        throw InvalidHasherValueException::handleDecode('foo');
    }
}
