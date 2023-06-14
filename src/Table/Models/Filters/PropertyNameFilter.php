<?php

namespace AzureOSS\Storage\Table\Models\Filters;

class PropertyNameFilter extends Filter
{
    private $_propertyName;

    /**
     * Constructor.
     *
     * @param string $propertyName The propertyName.
     */
    public function __construct($propertyName)
    {
        $this->_propertyName = $propertyName;
    }

    /**
     * Gets propertyName
     *
     * @return string
     */
    public function getPropertyName()
    {
        return $this->_propertyName;
    }
}
