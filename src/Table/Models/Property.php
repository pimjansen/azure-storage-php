<?php

namespace AzureOSS\Storage\Table\Models;

class Property
{
    private $edmType;
    private $value;
    private $rawValue;

    /**
     * Gets the type of the property.
     *
     * @return string
     */
    public function getEdmType()
    {
        return $this->edmType;
    }

    /**
     * Sets the value of the property.
     *
     * @param string $edmType The property type.
     */
    public function setEdmType($edmType)
    {
        EdmType::isValid($edmType);
        $this->edmType = $edmType;
    }

    /**
     * Gets the value of the property.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the property value.
     *
     * @param mixed $value The value of property.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Gets the raw value of the property.
     *
     * @return string
     */
    public function getRawValue()
    {
        return $this->rawValue;
    }

    /**
     * Sets the raw property value.
     *
     * @param mixed $rawValue The raw value of property.
     */
    public function setRawValue($rawValue)
    {
        $this->rawValue = $rawValue;
    }
}
