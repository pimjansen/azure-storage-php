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

namespace MicrosoftAzure\Storage\Tests\Unit\Table\Models;

use MicrosoftAzure\Storage\Table\Models\EdmType;
use MicrosoftAzure\Storage\Table\Models\Filters\Filter;
use MicrosoftAzure\Storage\Table\Models\Query;

/**
 * Unit tests for class Query
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class QueryTest extends \PHPUnit\Framework\TestCase
{
    public function testSetSelectFields()
    {
        // Setup
        $query = new Query();
        $expected = ['customerId', 'customerName'];

        // Test
        $query->setSelectFields($expected);

        // Assert
        self::assertEquals($expected, $query->getSelectFields());
    }

    public function testSetTop()
    {
        // Setup
        $query = new Query();
        $expected = 123;

        // Test
        $query->setTop($expected);

        // Assert
        self::assertEquals($expected, $query->getTop());
    }

    public function testSetFilter()
    {
        // Setup
        $query = new Query();
        $expected = Filter::applyConstant('constValue', EdmType::STRING);

        // Test
        $query->setFilter($expected);

        // Assert
        self::assertEquals($expected, $query->getFilter());
    }

    public function testAddSelectField()
    {
        // Setup
        $query = new Query();
        $field = 'customerId';
        $expected = [$field];

        // Test
        $query->addSelectField($field);

        // Assert
        self::assertEquals($expected, $query->getSelectFields());
    }
}
