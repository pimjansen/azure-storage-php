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

namespace MicrosoftAzure\Storage\Table\Models;

/**
 * Holds optional parameters for deleteEntity API.
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class DeleteEntityOptions extends TableServiceOptions
{
    private $_etag;

    /**
     * Gets entity etag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->_etag;
    }

    /**
     * Sets entity etag.
     *
     * @param string $etag The entity ETag.
     */
    public function setETag($etag)
    {
        $this->_etag = $etag;
    }
}
