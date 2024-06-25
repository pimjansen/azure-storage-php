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

namespace AzureOSS\Storage\Tests\Unit\Common\Internal\Serialization;

use AzureOSS\Storage\Common\Internal\Serialization\XmlSerializer;
use AzureOSS\Storage\Common\Models\ServiceProperties;
use AzureOSS\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class XmlSerializer
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class XmlSerializerTest extends \PHPUnit\Framework\TestCase
{
    public function testUnserialize()
    {
        // Setup
        $xmlSerializer = new XmlSerializer();
        $propertiesSample = TestResources::getServicePropertiesSample();
        $properties = ServiceProperties::create($propertiesSample);
        $xml = $properties->toXml($xmlSerializer);
        $expected = $properties->toArray();
        // Test
        $actual = $xmlSerializer->unserialize($xml);

        self::assertEquals($propertiesSample, $actual);
    }

    public function testSerialize()
    {
        // Setup
        $xmlSerializer = new XmlSerializer();
        $propertiesSample = TestResources::getServicePropertiesSample();
        $properties = ServiceProperties::create($propertiesSample);
        $expected = $properties->toXml($xmlSerializer);
        $array = $properties->toArray();
        $serializerProperties = [XmlSerializer::ROOT_NAME => 'StorageServiceProperties'];

        // Test
        $actual = $xmlSerializer->serialize($array, $serializerProperties);

        self::assertEquals($expected, $actual);
    }

    public function testSerializeAttribute()
    {
        // Setup
        $xmlSerializer = new XmlSerializer();
        $expected = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
            '<Object field1="value1" field2="value2"/>' . "\n";

        $object = [
            '@attributes' => [
                'field1' => 'value1',
                'field2' => 'value2',
            ],
        ];
        $serializerProperties = [XmlSerializer::ROOT_NAME => 'Object'];

        // Test
        $actual = $xmlSerializer->serialize($object, $serializerProperties);

        self::assertEquals($expected, $actual);
    }

    public function testObjectSerializeSucceess()
    {
        // Setup
        $expected = "<DummyClass/>\n";
        $target = new DummyClass();

        // Test
        $actual = XmlSerializer::objectSerialize($target, 'DummyClass');

        // Assert
        self::assertEquals(
            $expected,
            $actual,
        );
    }

    public function testObjectSerializeSucceessWithAttributes()
    {
        // Setup
        $expected = "<DummyClass testAttribute=\"testAttributeValue\"/>\n";
        $target = new DummyClass();
        $target->addAttribute('testAttribute', 'testAttributeValue');

        // Test
        $actual = XmlSerializer::objectSerialize($target, 'DummyClass');

        // Assert
        self::assertEquals(
            $expected,
            $actual,
        );
    }

    public function testObjectSerializeInvalidObject()
    {
        // Setup
        $this->expectException(get_class(new \InvalidArgumentException()));
        // Test
        $actual = XmlSerializer::objectSerialize(null, null);
        // Assert
    }
}
