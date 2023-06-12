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

use MicrosoftAzure\Storage\Common\Models\RangeDiff;

/**
 * Unit tests for class RangeDiff
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class RangeDiffTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        // Setup
        $expectedStart = 0;
        $expectedEnd = 512;
        $expectedIsClearedPageRange = false;

        // Test
        $actual = new RangeDiff($expectedStart, $expectedEnd, $expectedIsClearedPageRange);

        // Assert
        self::assertEquals($expectedStart, $actual->getStart());
        self::assertEquals($expectedEnd, $actual->getEnd());
        self::assertEquals($expectedIsClearedPageRange, $actual->isClearedPageRange());

        return $actual;
    }

    /**
     * @depends testConstruct
     */
    public function testIsClearedPageRange($obj)
    {
        // Setup
        $excepted = true;
        $obj->setIsClearedPageRange($excepted);

        // Test
        $actual = $obj->isClearedPageRange();

        // Assert
        self::assertEquals($excepted, $actual);

        // Setup
        $excepted = false;
        $obj->setIsClearedPageRange($excepted);

        // Test
        $actual = $obj->isClearedPageRange();

        // Assert
        self::assertEquals($excepted, $actual);
    }
}
