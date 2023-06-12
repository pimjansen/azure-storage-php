<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @see      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Tests\Unit\Common\Models;

use MicrosoftAzure\Storage\Common\Models\Range;

/**
 * Unit tests for class Range
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class RangeTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        // Setup
        $expectedStart = 0;
        $expectedEnd = 512;

        // Test
        $actual = new Range($expectedStart, $expectedEnd);

        // Assert
        self::assertEquals($expectedStart, $actual->getStart());
        self::assertEquals($expectedEnd, $actual->getEnd());

        return $actual;
    }

    /**
     * @depends testConstruct
     */
    public function testSetStart($obj)
    {
        // Setup
        $expected = 10;

        // Test
        $obj->setStart($expected);

        // Assert
        self::assertEquals($expected, $obj->getStart());
    }

    /**
     * @depends testConstruct
     */
    public function testSetEnd($obj)
    {
        // Setup
        $expected = 10;

        // Test
        $obj->setEnd($expected);

        // Assert
        self::assertEquals($expected, $obj->getEnd());
    }

    /**
     * @depends testConstruct
     */
    public function testSetLength($obj)
    {
        // Setup
        $expected = 10;
        $start = $obj->getStart();

        // Test
        $obj->setLength($expected);

        // Assert
        self::assertEquals($start + $expected - 1, $obj->getEnd());
    }

    /**
     * @depends testConstruct
     */
    public function testGetLength($obj)
    {
        // Setup
        $expected = 10;
        $obj->setLength($expected);

        // Test
        $actual = $obj->getLength();

        // Assert
        self::assertEquals($expected, $actual);
    }
}
