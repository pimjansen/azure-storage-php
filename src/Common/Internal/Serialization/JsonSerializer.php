<?php

namespace AzureOSS\Storage\Common\Internal\Serialization;

use AzureOSS\Storage\Common\Internal\Validate;

class JsonSerializer implements ISerializer
{
    /**
     * Serialize an object with specified root element name.
     *
     * @param object $targetObject The target object.
     * @param string $rootName     The name of the root element.
     *
     * @return string
     */
    public static function objectSerialize($targetObject, $rootName)
    {
        Validate::notNull($targetObject, 'targetObject');
        Validate::canCastAsString($rootName, 'rootName');

        $contianer = new \stdClass();

        $contianer->$rootName = $targetObject;

        return json_encode($contianer);
    }

    /**
     * Serializes given array. The array indices must be string to use them as
     * as element name.
     *
     * @param array $array      The object to serialize represented in array.
     * @param array $properties The used properties in the serialization process.
     *
     * @return string
     */
    public function serialize(array $array = null, array $properties = null)
    {
        Validate::isArray($array, 'array');

        return json_encode($array);
    }

    /**
     * Unserializes given serialized string to array.
     *
     * @param string $serialized The serialized object in string representation.
     *
     * @return array
     */
    public function unserialize($serialized)
    {
        Validate::canCastAsString($serialized, 'serialized');

        $json = json_decode($serialized);
        if ($json && !is_array($json)) {
            return get_object_vars($json);
        }
        return $json;
    }
}
