<?php

namespace AzureOSS\Storage\Queue\Models;

class Queue
{
    private $_name;
    private $_url;
    private $_metadata;

    /**
     * Constructor
     *
     * @param string $name queue name.
     * @param string $url  queue url.
     *
     * @return Queue
     */
    public function __construct($name, $url)
    {
        $this->_name = $name;
        $this->_url = $url;
    }

    /**
     * Gets queue name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets queue name.
     *
     * @param string $name value.
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Gets queue url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Sets queue url.
     *
     * @param string $url value.
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

    /**
     * Gets queue metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->_metadata;
    }

    /**
     * Sets queue metadata.
     *
     * @param array $metadata value.
     */
    public function setMetadata(array $metadata)
    {
        $this->_metadata = $metadata;
    }
}
