<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class Share
{
    private $name;
    private $metadata;
    private $properties;

    /**
     * Creates an instance with given response array.
     *
     * @param array $parsedResponse The response array.
     *
     * @return Share
     */
    public static function create(array $parsedResponse)
    {
        $result = new Share();
        $result->setName($parsedResponse[Resources::QP_NAME]);
        $result->setMetadata(
            Utilities::tryGetValue($parsedResponse, Resources::QP_METADATA, [])
        );
        $result->setProperties(ShareProperties::create(
            $parsedResponse[Resources::QP_PROPERTIES]
        ));
        return $result;
    }

    /**
     * Gets share name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets share name.
     *
     * @param string $name value.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets share metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Sets share metadata.
     *
     * @param array $metadata value.
     */
    public function setMetadata(array $metadata = null)
    {
        $this->metadata = $metadata;
    }

    /**
     * Gets share properties
     *
     * @return ShareProperties
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Sets share properties
     *
     * @param ShareProperties $properties share properties
     */
    public function setProperties(ShareProperties $properties)
    {
        $this->properties = $properties;
    }
}
