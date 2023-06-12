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

namespace MicrosoftAzure\Storage\Tests\Unit\Common\Internal\Http;

use MicrosoftAzure\Storage\Common\Internal\Http\HttpCallContext;

/**
 * Unit tests for class HttpCallContext
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class HttpCallContextTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        // Test
        $context = new HttpCallContext();

        // Assert
        self::assertNull($context->getBody());
        self::assertNull($context->getMethod());
        self::assertNull($context->getPath());
        self::assertNull($context->getUri());
        self::assertIsString($context->__toString());
        self::assertIsArray($context->getHeaders());
        self::assertIsArray($context->getQueryParameters());
        self::assertIsArray($context->getStatusCodes());

        return $context;
    }

    /**
     * @depends testConstruct
     */
    public function testSetMethod($context)
    {
        // Setup
        $expected = 'Method';

        // Test
        $context->setMethod($expected);

        // Assert
        self::assertEquals($expected, $context->getMethod());
    }

    /**
     * @depends testConstruct
     */
    public function testSetBody($context)
    {
        // Setup
        $expected = 'Body';

        // Test
        $context->setBody($expected);

        // Assert
        self::assertEquals($expected, $context->getBody());
    }

    /**
     * @depends testConstruct
     */
    public function testSetPath($context)
    {
        // Setup
        $expected = 'Path';

        // Test
        $context->setPath($expected);

        // Assert
        self::assertEquals($expected, $context->getPath());
    }

    /**
     * @depends testConstruct
     */
    public function testSetUri($context)
    {
        // Setup
        $expected = 'http://www.microsoft.com';

        // Test
        $context->setUri($expected);

        // Assert
        self::assertEquals($expected, $context->getUri());
    }

    /**
     * @depends testConstruct
     */
    public function testSetHeaders($context)
    {
        // Setup
        $expected = ['value1', 'value2', 'value3'];

        // Test
        $context->setHeaders($expected);

        // Assert
        self::assertEquals($expected, $context->getHeaders());
    }

    /**
     * @depends testConstruct
     */
    public function testSetQueryParameters($context)
    {
        // Setup
        $expected = ['value1', 'value2', 'value3'];

        // Test
        $context->setQueryParameters($expected);

        // Assert
        self::assertEquals($expected, $context->getQueryParameters());
    }

    /**
     * @depends testConstruct
     */
    public function testSetStatusCodes($context)
    {
        // Setup
        $expected = [1, 2, 3];

        // Test
        $context->setStatusCodes($expected);

        // Assert
        self::assertEquals($expected, $context->getStatusCodes());
    }

    /**
     * @depends testConstruct
     */
    public function testAddHeader($context)
    {
        // Setup
        $expected = 'value';
        $key = 'key';

        // Test
        $context->addHeader($key, $expected);

        // Assert
        self::assertEquals($expected, $context->getHeader($key));
    }

    /**
     * @depends testConstruct
     */
    public function testRemoveHeader($context)
    {
        // Setup
        $value = 'value';
        $key = 'key';
        $context->addHeader($key, $value);

        // Test
        $context->removeHeader($key);

        // Assert
        self::assertArrayNotHasKey($key, $context->getHeaders());
    }

    /**
     * @depends testConstruct
     */
    public function testToString($context)
    {
        // Setup
        $headers = ['h1' => 'v1', 'h2' => 'v2'];
        $method = 'GET';
        $uri = 'http://microsoft.com';
        $path = 'windowsazure/services';
        $body = 'The request body';
        $expected = "GET http://microsoft.com/windowsazure/services HTTP/1.1\nh1: v1\nh2: v2\n\nThe request body";
        $context->setHeaders($headers);
        $context->setMethod($method);
        $context->setUri($uri);
        $context->setPath($path);
        $context->setBody($body);

        // Test
        $actual = $context->__toString();

        // Assert
        self::assertEquals($expected, $actual);
    }
}
