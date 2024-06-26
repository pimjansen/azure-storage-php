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

namespace AzureOSS\Storage\Tests\Mock\Common\Internal\Authentication;

use AzureOSS\Storage\Common\Internal\Authentication\SharedKeyAuthScheme;

/**
 * Mock class to wrap SharedKeyAuthScheme class.
 *
 * @see       https://github.com/azure/azure-storage-php
 */
class SharedKeyAuthSchemeMock extends SharedKeyAuthScheme
{
    public function getAccountName()
    {
        return $this->accountName;
    }

    public function getAccountKey()
    {
        return $this->accountKey;
    }

    public function getIncludedHeaders()
    {
        return $this->includedHeaders;
    }

    public function computeSignatureMock($headers, $url, $queryParams, $httpMethod)
    {
        return parent::computeSignature($headers, $url, $queryParams, $httpMethod);
    }

    public function computeCanonicalizedHeadersMock($headers)
    {
        return parent::computeCanonicalizedHeaders($headers);
    }

    public function computeCanonicalizedResourceMock($url, $queryParams)
    {
        return parent::computeCanonicalizedResource($url, $queryParams);
    }

    public function computeCanonicalizedResourceForTableMock($url, $queryParams)
    {
        return parent::computeCanonicalizedResourceForTable($url, $queryParams);
    }
}
