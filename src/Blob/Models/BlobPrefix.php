<?php

namespace AzureOSS\Storage\Blob\Models;

class BlobPrefix
{
    private $_name;

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
}
