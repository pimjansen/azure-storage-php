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

namespace AzureOSS\Storage\Tests\Unit\Common\Internal\Authentication;

use AzureOSS\Storage\Common\Internal\Authentication\TokenAuthScheme;
use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Tests\Framework\ReflectionTestBase;
use AzureOSS\Storage\Tests\Framework\TestResources;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

/**
 * Unit tests for TokenAuthScheme class.
 *
 * @see       https://github.com/azure/azure-storage-php
 */
class TokenAuthSchemeTest extends ReflectionTestBase
{
    public function testConstruct()
    {
        $bearerToken = '';
        $mock = new TokenAuthScheme($bearerToken, TestResources::TOKEN_CS);

        self::assertEquals('', $this->getProperty('tokenRef', $mock)->getValue($mock));
        $bearerToken = 'changed';
        self::assertEquals('changed', $this->getProperty('tokenRef', $mock)->getValue($mock));
    }

    public function testSignRequest()
    {
        $bearerToken = '';
        $mock = new TokenAuthScheme($bearerToken, TestResources::TOKEN_CS);
        $uri = new Uri(TestResources::URI2);
        $request = new Request('Get', $uri, [], null);
        $actual = $mock->signRequest($request);
        self::assertArrayHasKey(strtolower(Resources::AUTHENTICATION), $actual->getHeaders());
        self::assertEquals(
            'Bearer', // Trims the trailing space
            $actual->getHeaders()[strtolower(Resources::AUTHENTICATION)][0],
        );

        $bearerToken = 'changed';
        $request = new Request('Get', $uri, [], null);
        $actual = $mock->signRequest($request);
        self::assertArrayHasKey(strtolower(Resources::AUTHENTICATION), $actual->getHeaders());
        self::assertEquals(
            'Bearer changed',
            $actual->getHeaders()[strtolower(Resources::AUTHENTICATION)][0],
        );
    }
}
