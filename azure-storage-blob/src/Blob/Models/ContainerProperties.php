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
use MicrosoftAzure\Storage\Common\Internal\Validate;

/**
 * Holds container properties fields
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class ContainerProperties
{
    private $etag;
    private $lastModified;
    private $leaseDuration;
    private $leaseStatus;
    private $leaseState;
    private $publicAccess;

    /**
     * Gets container lastModified.
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Sets container lastModified.
     *
     * @param \DateTime $lastModified value.
     */
    public function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * Gets container etag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->etag;
    }

    /**
     * Sets container etag.
     *
     * @param string $etag value.
     */
    public function setETag($etag)
    {
        $this->etag = $etag;
    }

    /**
     * Gets blob leaseStatus.
     *
     * @return string
     */
    public function getLeaseStatus()
    {
        return $this->leaseStatus;
    }

    /**
     * Sets blob leaseStatus.
     *
     * @param string $leaseStatus value.
     */
    public function setLeaseStatus($leaseStatus)
    {
        $this->leaseStatus = $leaseStatus;
    }

    /**
     * Gets blob lease state.
     *
     * @return string
     */
    public function getLeaseState()
    {
        return $this->leaseState;
    }

    /**
     * Sets blob lease state.
     *
     * @param string $leaseState value.
     */
    public function setLeaseState($leaseState)
    {
        $this->leaseState = $leaseState;
    }

    /**
     * Gets blob lease duration.
     *
     * @return string
     */
    public function getLeaseDuration()
    {
        return $this->leaseDuration;
    }

    /**
     * Sets blob leaseStatus.
     *
     * @param string $leaseDuration value.
     */
    public function setLeaseDuration($leaseDuration)
    {
        $this->leaseDuration = $leaseDuration;
    }

    /**
     * Gets container publicAccess.
     *
     * @return string
     */
    public function getPublicAccess()
    {
        return $this->publicAccess;
    }

    /**
     * Sets container publicAccess.
     *
     * @param string $publicAccess value.
     */
    public function setPublicAccess($publicAccess)
    {
        Validate::isTrue(
            PublicAccessType::isValid($publicAccess),
            Resources::INVALID_BLOB_PAT_MSG
        );
        $this->publicAccess = $publicAccess;
    }
}
