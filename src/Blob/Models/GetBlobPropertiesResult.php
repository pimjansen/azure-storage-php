<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Internal\MetadataTrait;

class GetBlobPropertiesResult
{
    use MetadataTrait;

    private $_properties;

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
    protected function setProperties($properties)
    {
        $this->_properties = $properties;
    }

    /**
     * Create a instance using the given headers.
     *
     * @param array $headers response headers parsed in an array
     *
     * @internal
     *
     * @return GetBlobPropertiesResult
     */
    public static function create(array $headers)
    {
        $result = static::createMetadataResult($headers);

        $result->setProperties(BlobProperties::createFromHttpHeaders($headers));

        return $result;
    }
}
