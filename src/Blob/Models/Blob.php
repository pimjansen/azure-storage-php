<?php

namespace AzureOSS\Storage\Blob\Models;

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
