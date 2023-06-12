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

namespace MicrosoftAzure\Storage\Tests\Unit\Common\Internal\Authentication;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;
use MicrosoftAzure\Storage\Tests\Mock\Common\Internal\Authentication\SharedAccessSignatureAuthSchemeMock;

/**
 * Unit tests for SharedAccessSignatureAuthScheme class.
 *
 * @link       https://github.com/azure/azure-storage-php
 */
class SharedAccessSignatureAuthSchemeTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $mock = new SharedAccessSignatureAuthSchemeMock(TestResources::SAS_TOKEN);
        $this->assertEquals(TestResources::SAS_TOKEN, $mock->getSasToken());

        $mock = new SharedAccessSignatureAuthSchemeMock('?' . TestResources::SAS_TOKEN);
        $this->assertEquals(TestResources::SAS_TOKEN, $mock->getSasToken());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructFromInvalidSASToken()
    {
        $mock = new SharedAccessSignatureAuthSchemeMock('?' . TestResources::SAS_TOKEN . '?foo=bar');
        $this->assertEquals(TestResources::SAS_TOKEN, $mock->getSasToken());
    }

    public function testSignRequest()
    {
        // Setup
        $mock = new SharedAccessSignatureAuthSchemeMock(TestResources::SAS_TOKEN);
        $uri = new Uri(TestResources::URI2);
        $request = new Request('Get', $uri, [], null);
        $expected = new Uri(TestResources::URI2 . '&' . TestResources::SAS_TOKEN);

        // Test
        $actual = $mock->signRequest($request)->getUri();

        $this->assertEquals($expected, $actual);
    }
}
