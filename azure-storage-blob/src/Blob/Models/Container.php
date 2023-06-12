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
 * WindowsAzure container object.
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class Container
{
    private $_name;
    private $_url;
    private $_metadata;
    private $_properties;

    /**
     * Gets container name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets container name.
     *
     * @param string $name value.
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Gets container url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Sets container url.
     *
     * @param string $url value.
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

    /**
     * Gets container metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->_metadata;
    }

    /**
     * Sets container metadata.
     *
     * @param array $metadata value.
     */
    public function setMetadata(array $metadata = null)
    {
        $this->_metadata = $metadata;
    }

    /**
     * Gets container properties
     *
     * @return ContainerProperties
     */
    public function getProperties()
    {
        return $this->_properties;
    }

    /**
     * Sets container properties
     *
     * @param ContainerProperties $properties container properties
     */
    public function setProperties(ContainerProperties $properties)
    {
        $this->_properties = $properties;
    }
}
