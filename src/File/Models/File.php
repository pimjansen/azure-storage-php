<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class File
{
    private $name;
    private $length;

    /**
     * Gets file name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets file name.
     *
     * @param string $name value.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets file length.
     *
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Sets file length.
     *
     * @param int $length value.
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * Creates a File object using the parsed array.
     *
     * @param array $parsed The parsed array that contains the object information.
     *
     * @return File
     */
    public static function create(array $parsed)
    {
        $result = new File();
        $name = Utilities::tryGetValue($parsed, Resources::QP_NAME);
        $result->setName($name);
        $properties = Utilities::tryGetValue($parsed, Resources::QP_PROPERTIES);
        $length = (int) (Utilities::tryGetValue($properties, Resources::QP_CONTENT_LENGTH));
        $result->setLength($length);
        return $result;
    }
}
