<?php

namespace AzureOSS\Storage\Table\Models\Filters;

use AzureOSS\Storage\Table\Models\EdmType;

class ConstantFilter extends Filter
{
    private $_value;
    private $_edmType;

    /**
     * Constructor.
     *
     * @param string $edmType The EDM type.
     * @param string $value   The EDM value.
     */
    public function __construct($edmType, $value)
    {
        $this->_edmType = EdmType::processType($edmType);
        $this->_value = $value;
    }

    /**
     * Gets value
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Gets the type of the constant.
     *
     * @return string
     */
    public function getEdmType()
    {
        return $this->_edmType;
    }
}
