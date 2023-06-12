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

namespace MicrosoftAzure\Storage\Tests\Unit\Blob\Models;

use MicrosoftAzure\Storage\Blob\Models\ListContainersOptions;

/**
 * Unit tests for class ListContainersOptions
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class ListContainersOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testSetPrefix()
    {
        // Setup
        $options = new ListContainersOptions();
        $expected = 'myprefix';

        // Test
        $options->setPrefix($expected);

        // Assert
        self::assertEquals($expected, $options->getPrefix());
    }

    public function testGetPrefix()
    {
        // Setup
        $options = new ListContainersOptions();
        $expected = 'myprefix';
        $options->setPrefix($expected);

        // Test
        $actual = $options->getPrefix();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetMarker()
    {
        // Setup
        $options = new ListContainersOptions();
        $expected = 'mymarker';

        // Test
        $options->setMarker($expected);

        // Assert
        self::assertEquals($expected, $options->getNextMarker());
    }

    public function testSetMaxResults()
    {
        // Setup
        $options = new ListContainersOptions();
        $expected = '3';

        // Test
        $options->setMaxResults($expected);

        // Assert
        self::assertEquals($expected, $options->getMaxResults());
    }

    public function testGetMaxResults()
    {
        // Setup
        $options = new ListContainersOptions();
        $expected = '3';
        $options->setMaxResults($expected);

        // Test
        $actual = $options->getMaxResults();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetIncludeMetadata()
    {
        // Setup
        $options = new ListContainersOptions();
        $expected = true;

        // Test
        $options->setIncludeMetadata($expected);

        // Assert
        self::assertEquals($expected, $options->getIncludeMetadata());
    }

    public function testGetIncludeMetadata()
    {
        // Setup
        $options = new ListContainersOptions();
        $expected = true;
        $options->setIncludeMetadata($expected);

        // Test
        $actual = $options->getIncludeMetadata();

        // Assert
        self::assertEquals($expected, $actual);
    }
}
