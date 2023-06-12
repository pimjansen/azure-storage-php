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

namespace MicrosoftAzure\Storage\Tests\Mock\Common\Internal\Authentication;

use MicrosoftAzure\Storage\Common\Internal\Authentication\SharedAccessSignatureAuthScheme;

/**
 * Mock class to wrap SharedAccessSignatureAuthScheme class.
 *
 * @link       https://github.com/azure/azure-storage-php
 */
class SharedAccessSignatureAuthSchemeMock extends SharedAccessSignatureAuthScheme
{
    public function __construct($sasToken)
    {
        parent::__construct($sasToken);
    }

    public function getSasToken()
    {
        return $this->sasToken;
    }
}
