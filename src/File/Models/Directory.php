<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class Directory
{
    private $name;

    /**
     * Gets directory name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets directory name.
     *
     * @param string $name value.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Creates a Directory object using the parsed array.
     *
     * @param array $parsed The parsed array that contains the object information.
     *
     * @return Directory
     */
    public static function create(array $parsed)
    {
        $result = new Directory();
        $name = Utilities::tryGetValue($parsed, Resources::QP_NAME);
        $result->setName($name);

        return $result;
    }
}
