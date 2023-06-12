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

/**
 * Represents windows azure blob object
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class Blob
{
    private $_name;
    private $_url;
    private $_snapshot;
    private $_metadata;
    private $_properties;

    /**
     * Gets blob name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets blob name.
     *
     * @param string $name value.
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Gets blob snapshot.
     *
     * @return string
     */
    public function getSnapshot()
    {
        return $this->_snapshot;
    }

    /**
     * Sets blob snapshot.
     *
     * @param string $snapshot value.
     */
    public function setSnapshot($snapshot)
    {
        $this->_snapshot = $snapshot;
    }

    /**
     * Gets blob url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Sets blob url.
     *
     * @param string $url value.
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

    /**
     * Gets blob metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->_metadata;
    }

    /**
     * Sets blob metadata.
     *
     * @param array $metadata value.
     */
    public function setMetadata(array $metadata = null)
    {
        $this->_metadata = $metadata;
    }

    /**
     * Gets blob properties.
     *
     * @return BlobProperties
     */
    public function getProperties()
    {
        return $this->_properties;
    }

    /**
     * Sets blob properties.
     *
     * @param BlobProperties $properties value.
     */
    public function setProperties($properties)
    {
        $this->_properties = $properties;
    }
}
