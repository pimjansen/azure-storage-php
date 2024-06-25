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

namespace AzureOSS\Storage\Tests\Unit\Common\Internal;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Internal\Serialization\XmlSerializer;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Models\ServiceProperties;
use AzureOSS\Storage\Tests\Framework\TestResources;
use GuzzleHttp\Psr7;

/**
 * Unit tests for class Utilities
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class UtilitiesTest extends \PHPUnit\Framework\TestCase
{
    public function testTryGetValue()
    {
        // Setup
        $key = 0;
        $expected = 10;
        $data = [10, 20, 30];

        // Test
        $actual = Utilities::tryGetValue($data, $key);

        self::assertEquals($expected, $actual);
    }

    public function testTryGetValueUsingDefault()
    {
        // Setup
        $key = 10;
        $expected = 6;
        $data = [10, 20, 30];

        // Test
        $actual = Utilities::tryGetValue($data, $key, $expected);

        self::assertEquals($expected, $actual);
    }

    public function testTryGetValueWithNull()
    {
        // Setup
        $key = 10;
        $data = [10, 20, 30];

        // Test
        $actual = Utilities::tryGetValue($data, $key);

        self::assertNull($actual);
    }

    public function testTryGetKeysChainValue()
    {
        // Setup
        $array = [];
        $array['a1'] = [];
        $array['a2'] = 'value1';
        $array['a1']['b1'] = [];
        $array['a1']['b2'] = 'value2';
        $array['a1']['b1']['c1'] = 'value3';

        // Test - Level 1
        self::assertEquals('value1', Utilities::tryGetKeysChainValue($array, 'a2'));
        self::assertNull(Utilities::tryGetKeysChainValue($array, 'a3'));

        // Test - Level 2
        self::assertEquals('value2', Utilities::tryGetKeysChainValue($array, 'a1', 'b2'));
        self::assertNull(Utilities::tryGetKeysChainValue($array, 'a1', 'b3'));

        // Test - Level 3
        self::assertEquals('value3', Utilities::tryGetKeysChainValue($array, 'a1', 'b1', 'c1'));
        self::assertNull(Utilities::tryGetKeysChainValue($array, 'a1', 'b1', 'c2'));
    }

    public function testStartsWith()
    {
        // Setup
        $string = 'myname';
        $prefix = 'my';

        // Test
        $actual = Utilities::startsWith($string, $prefix);

        self::assertTrue($actual);
    }

    public function testStartsWithDoesNotStartWithPrefix()
    {
        // Setup
        $string = 'amyname';
        $prefix = 'my';

        // Test
        $actual = Utilities::startsWith($string, $prefix);

        self::assertFalse($actual);
    }

    public function testGetArray()
    {
        // Setup
        $expected = [[1, 2, 3, 4],  [5, 6, 7, 8]];

        // Test
        $actual = Utilities::getArray($expected);

        self::assertEquals($expected, $actual);
    }

    public function testGetArrayWithFlatValue()
    {
        // Setup
        $flat = [1, 2, 3, 4, 5, 6, 7, 8];
        $expected = [[1, 2, 3, 4, 5, 6, 7, 8]];

        // Test
        $actual = Utilities::getArray($flat);

        self::assertEquals($expected, $actual);
    }

    public function testGetArrayWithMixtureValue()
    {
        // Setup
        $flat = [[10, 2], 1, 2, 3, 4, 5, 6, 7, 8];
        $expected = [[[10, 2], 1, 2, 3, 4, 5, 6, 7, 8]];

        // Test
        $actual = Utilities::getArray($flat);

        self::assertEquals($expected, $actual);
    }

    public function testGetArrayWithEmptyValue()
    {
        // Setup
        $empty = [];
        $expected = [];

        // Test
        $actual = Utilities::getArray($empty);

        self::assertEquals($expected, $actual);
    }

    public function testUnserialize()
    {
        // Setup
        $propertiesSample = TestResources::getServicePropertiesSample();
        $properties = ServiceProperties::create($propertiesSample);
        $xmlSerializer = new XmlSerializer();
        $xml = $properties->toXml($xmlSerializer);

        // Test
        $actual = Utilities::unserialize($xml);

        self::assertEquals($propertiesSample, $actual);
    }

    public function testSerialize()
    {
        // Setup
        $propertiesSample = TestResources::getServicePropertiesSample();
        $properties = ServiceProperties::create($propertiesSample);

        $expected = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $expected .= '<StorageServiceProperties><Logging><Version>1.0</Version><Delete>true</Delete>';
        $expected .= '<Read>false</Read><Write>true</Write><RetentionPolicy><Enabled>true</Enabled>';
        $expected .= '<Days>20</Days></RetentionPolicy></Logging><HourMetrics><Version>1.0</Version>';
        $expected .= '<Enabled>true</Enabled><IncludeAPIs>false</IncludeAPIs><RetentionPolicy>';
        $expected .= '<Enabled>true</Enabled><Days>20</Days></RetentionPolicy></HourMetrics>';
        $expected .= '<MinuteMetrics><Version>1.0</Version><Enabled>true</Enabled>';
        $expected .= '<IncludeAPIs>false</IncludeAPIs><RetentionPolicy><Enabled>true</Enabled>';
        $expected .= '<Days>20</Days></RetentionPolicy></MinuteMetrics>';
        $expected .= '<Cors><CorsRule><AllowedOrigins>http://www.microsoft.com,http://www.bing.com</AllowedOrigins>';
        $expected .= '<AllowedMethods>GET,PUT</AllowedMethods>';
        $expected .= '<AllowedHeaders>x-ms-meta-customheader0,x-ms-meta-target0*</AllowedHeaders>';
        $expected .= '<ExposedHeaders>x-ms-meta-customheader0,x-ms-meta-data0*</ExposedHeaders>';
        $expected .= '<MaxAgeInSeconds>500</MaxAgeInSeconds>';
        $expected .= '</CorsRule><CorsRule><AllowedOrigins>http://www.azure.com,http://www.office.com</AllowedOrigins>';
        $expected .= '<AllowedMethods>POST,HEAD</AllowedMethods><AllowedHeaders>';
        $expected .= 'x-ms-meta-customheader1,x-ms-meta-target1*</AllowedHeaders>';
        $expected .= '<ExposedHeaders>x-ms-meta-customheader1,x-ms-meta-data1*';
        $expected .= '</ExposedHeaders><MaxAgeInSeconds>350</MaxAgeInSeconds>';
        $expected .= '</CorsRule></Cors></StorageServiceProperties>';

        $array = $properties->toArray();

        // Test
        $actual = Utilities::serialize($array, 'StorageServiceProperties');

        self::assertEquals($expected, $actual);
    }

    public function testSerializeAttribute()
    {
        // Setup
        $expected = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
            '<Object field1="value1" field2="value2"/>';

        $object = [
            '@attributes' => [
                'field1' => 'value1',
                'field2' => 'value2',
            ],
        ];

        // Test
        $actual = Utilities::serialize($object, 'Object');

        self::assertEquals($expected, $actual);
    }

    public function testAllZero()
    {
        self::assertFalse(Utilities::allZero('hello'));

        for ($i = 1; $i < 256; ++$i) {
            self::assertFalse(Utilities::allZero(pack('c', $i)));
        }

        self::assertTrue(Utilities::allZero(pack('c', 0)));

        self::assertTrue(Utilities::allZero(''));
    }

    public function testToBoolean()
    {
        self::assertIsBool(Utilities::toBoolean('true'));
        self::assertTrue(Utilities::toBoolean('true'));

        self::assertIsBool(Utilities::toBoolean('false'));
        self::assertFalse(Utilities::toBoolean('false'));

        self::assertIsBool(Utilities::toBoolean(null));
        self::assertFalse(Utilities::toBoolean(null));

        self::assertIsBool(Utilities::toBoolean('true', true));
        self::assertTrue(Utilities::toBoolean('true', true));

        self::assertIsBool(Utilities::toBoolean('false', true));
        self::assertFalse(Utilities::toBoolean('false', true));

        self::assertNull(Utilities::toBoolean(null, true));
        self::assertNull(Utilities::toBoolean(null, true));
    }

    public function testBooleanToString()
    {
        // Setup
        $expected = 'true';
        $value = true;

        // Test
        $actual = Utilities::booleanToString($value);

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testIsoDate()
    {
        // Test
        $date = Utilities::isoDate(new \DateTimeImmutable('2016-02-03', new \DateTimeZone('America/Chicago')));

        // Assert
        self::assertSame('2016-02-03T06:00:00Z', $date);
    }

    public function testConvertToEdmDateTime()
    {
        // Test
        $actual = Utilities::convertToEdmDateTime(new \DateTime());

        // Assert
        self::assertNotNull($actual);
    }

    public function testConvertToDateTime()
    {
        // Setup
        $date = '2008-10-01T15:26:13Z';

        // Test
        $actual = Utilities::convertToDateTime($date);

        // Assert
        self::assertInstanceOf('\DateTime', $actual);
    }

    public function testConvertToDateTimeWithDate()
    {
        // Setup
        $date = new \DateTime();

        // Test
        $actual = Utilities::convertToDateTime($date);

        // Assert
        self::assertEquals($date, $actual);
    }

    public function testStringToStream()
    {
        $data = 'This is string';
        $expected = fopen('data://text/plain,' . $data, 'r');

        // Test
        $actual = Utilities::stringToStream($data);

        // Assert
        self::assertEquals(stream_get_contents($expected), stream_get_contents($actual));
    }

    public function testWindowsAzureDateToDateTime()
    {
        // Setup
        $expected = 'Fri, 16 Oct 2009 21:04:30 GMT';

        // Test
        $actual = Utilities::rfc1123ToDateTime($expected);

        // Assert
        self::assertEquals($expected, $actual->format('D, d M Y H:i:s T'));
    }

    public function testTryAddUrlSchemeWithScheme()
    {
        // Setup
        $url = 'http://microsoft.com';

        // Test
        $actual = Utilities::tryAddUrlScheme($url);

        // Assert
        self::assertEquals($url, $actual);
    }

    public function testTryAddUrlSchemeWithoutScheme()
    {
        // Setup
        $url = 'microsoft.com';
        $expected = 'http://microsoft.com';

        // Test
        $actual = Utilities::tryAddUrlScheme($url);

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testTryGetSecondaryEndpointFromPrimaryEndpoint()
    {
        self::assertEquals(
            'http://account-secondary.blob.core.windows.net',
            Utilities::tryGetSecondaryEndpointFromPrimaryEndpoint(
                'http://account.blob.core.windows.net',
            ),
        );

        self::assertEquals(
            'https://account-secondary.blob.core.windows.net',
            Utilities::tryGetSecondaryEndpointFromPrimaryEndpoint(
                'https://account.blob.core.windows.net',
            ),
        );

        self::assertEquals(
            'account-secondary.blob.core.windows.net',
            Utilities::tryGetSecondaryEndpointFromPrimaryEndpoint(
                'account.blob.core.windows.net',
            ),
        );

        self::assertEquals(
            'http://account-secondary.customized',
            Utilities::tryGetSecondaryEndpointFromPrimaryEndpoint(
                'http://account.customized',
            ),
        );

        self::assertEquals(
            'http://account-secondary.blob.core.windows.net/foo/bar?a=b',
            Utilities::tryGetSecondaryEndpointFromPrimaryEndpoint(
                'http://account.blob.core.windows.net/foo/bar?a=b',
            ),
        );

        self::assertNull(
            Utilities::tryGetSecondaryEndpointFromPrimaryEndpoint(
                '',
            ),
        );
    }

    public function testStartsWithIgnoreCase()
    {
        // Setup
        $string = 'MYString';
        $prefix = 'mY';

        // Test
        $actual = Utilities::startsWith($string, $prefix, true);

        // Assert
        self::assertTrue($actual);
    }

    public function testInArrayInsensitive()
    {
        // Setup
        $value = 'CaseInsensitiVe';
        $array = ['caSeinSenSitivE'];

        // Test
        $actual = Utilities::inArrayInsensitive($value, $array);

        // Assert
        self::assertTrue($actual);
    }

    public function testArrayKeyExistsInsensitive()
    {
        // Setup
        $key = 'CaseInsensitiVe';
        $array = ['caSeinSenSitivE' => '123'];

        // Test
        $actual = Utilities::arrayKeyExistsInsensitive($key, $array);

        // Assert
        self::assertTrue($actual);
    }

    public function testTryGetValueInsensitive()
    {
        // Setup
        $key = 'KEy';
        $value = 1;
        $array = [$key => $value];

        // Test
        $actual = Utilities::tryGetValueInsensitive('keY', $array);

        // Assert
        self::assertEquals($value, $actual);
    }

    public function testGetGuid()
    {
        // Test
        $actual1 = Utilities::getGuid();
        $actual2 = Utilities::getGuid();

        // Assert
        self::assertNotNull($actual1);
        self::assertNotNull($actual2);
        self::assertIsString($actual1);
        self::assertIsString($actual2);
        self::assertNotEquals($actual1, $actual2);
    }

    public function testEndsWith()
    {
        // Setup
        $haystack = 'tesT';
        $needle = 't';
        $expected = true;

        // Test
        $actual = Utilities::endsWith($haystack, $needle, true);

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testGenerateCryptoKey()
    {
        // Setup
        $length = 32;

        // Test
        $result = Utilities::generateCryptoKey($length);

        // Assert
        self::assertEquals($length, strlen($result));
    }

    public function testBase256ToDecF()
    {
        // Setup
        $data = pack('C*', 255, 255, 255, 255);
        $expected = 4294967295;

        // Test
        $actual = Utilities::base256ToDec($data);

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testBase256ToDec0()
    {
        // Setup
        $data = pack('C*', 0, 0, 0, 0);
        $expected = 0;

        // Test
        $actual = Utilities::base256ToDec($data);

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testBase256ToDec()
    {
        // Setup
        $data = pack('C*', 34, 78, 27, 55);
        $expected = 575544119;

        // Test
        $actual = Utilities::base256ToDec($data);

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testBase256ToDecBig()
    {
        // Setup
        $data = pack('C*', 81, 35, 29, 39, 236, 104, 105, 144); //51 23 1D 27 EC 68 69 90
        $expected = '5846548798564231568';

        // Test
        $actual = Utilities::base256ToDec($data);

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testIsStreamLargerThanSizeOrNotSeekable()
    {
        //prepare a file
        $cwd = getcwd();
        $uuid = uniqid('test-file-', true);
        $path = $cwd . DIRECTORY_SEPARATOR . $uuid . '.txt';
        $resource = fopen($path, 'w+');
        $count = 64 / 4;
        for ($index = 0; $index < $count; ++$index) {
            fwrite($resource, openssl_random_pseudo_bytes(4194304));
        }
        rewind($resource);
        $stream = Psr7\Utils::streamFor($resource);
        $result_0 = Utilities::isStreamLargerThanSizeOrNotSeekable(
            $stream,
            4194304 * 16 - 1,
        );
        $result_1 = Utilities::isStreamLargerThanSizeOrNotSeekable(
            $stream,
            4194304 * 16,
        );
        //prepare a string
        $count = 64 / 4;
        $testStr = openssl_random_pseudo_bytes(4194304 * $count);
        $stream = Psr7\Utils::streamFor($testStr);
        $result_2 = Utilities::isStreamLargerThanSizeOrNotSeekable(
            $stream,
            4194304 * 16 - 1,
        );
        $result_3 = Utilities::isStreamLargerThanSizeOrNotSeekable(
            $stream,
            4194304 * 16,
        );

        self::assertFalse($result_1);
        self::assertFalse($result_3);
        self::assertTrue($result_0);
        self::assertTrue($result_2);
        if (is_resource($resource)) {
            fclose($resource);
        }
        // Delete file after assertion.
        unlink($path);
    }

    public function testGetMetadataArray()
    {
        // Setup
        $expected = ['key1' => 'value1', 'myname' => 'azure', 'mycompany' => 'microsoft_'];
        $metadataHeaders = [];
        foreach ($expected as $key => $value) {
            $metadataHeaders[Resources::X_MS_META_HEADER_PREFIX . strtolower($key)] = $value;
        }

        // Test
        $actual = Utilities::getMetadataArray($metadataHeaders);

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testGetMetadataArrayWithMsHeaders()
    {
        // Setup
        $key = 'name';
        $validMetadataKey = Resources::X_MS_META_HEADER_PREFIX . $key;
        $value = 'correct';
        $metadataHeaders = ['x-ms-key1' => 'value1', 'myname' => 'x-ms-date',
            $validMetadataKey => $value, 'mycompany' => 'microsoft_'];

        // Test
        $actual = Utilities::getMetadataArray($metadataHeaders);

        // Assert
        self::assertCount(1, $actual);
        self::assertEquals($value, $actual[$key]);
    }
}
