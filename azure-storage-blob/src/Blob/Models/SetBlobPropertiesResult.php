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

namespace MicrosoftAzure\Storage\Blob\Models;

use MicrosoftAzure\Storage\Blob\Internal\BlobResources as Resources;
use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\Common\Internal\Validate;

/**
 * Holds result of calling setBlobProperties wrapper
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class SetBlobPropertiesResult
{
    private $_lastModified;
    private $_etag;
    private $_sequenceNumber;

    /**
     * Creates SetBlobPropertiesResult from response headers.
     *
     * @param array $headers response headers
     *
     * @internal
     *
     * @return SetBlobPropertiesResult
     */
    public static function create(array $headers)
    {
        $result = new SetBlobPropertiesResult();
        $date = Utilities::tryGetValueInsensitive(
            Resources::LAST_MODIFIED,
            $headers
        );
        $result->setLastModified(Utilities::rfc1123ToDateTime($date));
        $result->setETag(Utilities::tryGetValueInsensitive(
            Resources::ETAG,
            $headers
        ));
        $result->setSequenceNumber(Utilities::tryGetValueInsensitive(
            Resources::X_MS_BLOB_SEQUENCE_NUMBER,
            $headers
        ));

        return $result;
    }

    /**
     * Gets blob lastModified.
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->_lastModified;
    }

    /**
     * Sets blob lastModified.
     *
     * @param \DateTime $lastModified value.
     */
    protected function setLastModified(\DateTime $lastModified)
    {
        Validate::isDate($lastModified);
        $this->_lastModified = $lastModified;
    }

    /**
     * Gets blob etag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->_etag;
    }

    /**
     * Sets blob etag.
     *
     * @param string $etag value.
     */
    protected function setETag($etag)
    {
        Validate::canCastAsString($etag, 'etag');
        $this->_etag = $etag;
    }

    /**
     * Gets blob sequenceNumber.
     *
     * @return int
     */
    public function getSequenceNumber()
    {
        return $this->_sequenceNumber;
    }

    /**
     * Sets blob sequenceNumber.
     *
     * @param int $sequenceNumber value.
     */
    protected function setSequenceNumber($sequenceNumber)
    {
        Validate::isInteger($sequenceNumber, 'sequenceNumber');
        $this->_sequenceNumber = $sequenceNumber;
    }
}
