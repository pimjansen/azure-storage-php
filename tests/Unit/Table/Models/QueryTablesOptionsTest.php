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

namespace AzureOSS\Storage\Tests\Unit\Table\Models;

use AzureOSS\Storage\Table\Models\EdmType;
use AzureOSS\Storage\Table\Models\Filters\Filter;
use AzureOSS\Storage\Table\Models\Query;
use AzureOSS\Storage\Table\Models\QueryTablesOptions;

/**
 * Unit tests for class QueryTablesOptions
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class QueryTablesOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testSetNextTableName()
    {
        // Setup
        $options = new QueryTablesOptions();
        $expected = 'table';

        // Test
        $options->setNextTableName($expected);

        // Assert
        self::assertEquals($expected, $options->getNextTableName());
    }

    public function testSetPrefix()
    {
        // Setup
        $options = new QueryTablesOptions();
        $expected = 'prefix';

        // Test
        $options->setPrefix($expected);

        // Assert
        self::assertEquals($expected, $options->getPrefix());
    }

    public function testSetTop()
    {
        // Setup
        $options = new QueryTablesOptions();
        $expected = 123;

        // Test
        $options->setTop($expected);

        // Assert
        self::assertEquals($expected, $options->getTop());
    }

    public function testGetQuery()
    {
        // Setup
        $options = new QueryTablesOptions();
        $expected = new Query();

        // Test
        $actual = $options->getQuery();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetFilter()
    {
        // Setup
        $options = new QueryTablesOptions();
        $expected = Filter::applyConstant('constValue', EdmType::STRING);

        // Test
        $options->setFilter($expected);

        // Assert
        self::assertEquals($expected, $options->getFilter());
    }
}
