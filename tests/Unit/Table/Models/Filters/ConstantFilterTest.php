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
 * @link      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Tests\Unit\Table\Models\Filters;

use MicrosoftAzure\Storage\Table\Models\EdmType;
use MicrosoftAzure\Storage\Table\Models\Filters\ConstantFilter;

/**
 * Unit tests for class ConstantFilter
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class ConstantFilterTest extends \PHPUnit\Framework\TestCase
{
    public function testGetValue()
    {
        // Setup
        $expected = 'x';
        $filter = new ConstantFilter(null, $expected);

        // Assert
        self::assertEquals($expected, $filter->getValue());
    }

    public function testGetEdmType()
    {
        // Setup
        $expected = EdmType::BINARY;
        $filter = new ConstantFilter($expected, '1234');

        // Assert
        self::assertEquals($expected, $filter->getEdmType());
    }
}
