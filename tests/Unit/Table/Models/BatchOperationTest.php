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

namespace MicrosoftAzure\Storage\Tests\Unit\Table\Models;

use MicrosoftAzure\Storage\Table\Models\BatchOperation;
use MicrosoftAzure\Storage\Table\Models\BatchOperationParameterName;
use MicrosoftAzure\Storage\Table\Models\BatchOperationType;

/**
 * Unit tests for class BatchOperation
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class BatchOperationTest extends \PHPUnit\Framework\TestCase
{
    public function testSetType()
    {
        // Setup
        $batchOperation = new BatchOperation();
        $expected = BatchOperationType::DELETE_ENTITY_OPERATION;

        // Test
        $batchOperation->setType($expected);

        // Assert
        self::assertEquals($expected, $batchOperation->getType());
    }

    public function testAddParameter()
    {
        // Setup
        $batchOperation = new BatchOperation();
        $expected = 'param zeta';
        $name = BatchOperationParameterName::BP_ENTITY;

        // Test
        $batchOperation->addParameter($name, $expected);

        // Assert
        self::assertEquals($expected, $batchOperation->getParameter($name));
    }
}
