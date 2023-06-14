<?php

namespace AzureOSS\Storage\Blob\Models;

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
