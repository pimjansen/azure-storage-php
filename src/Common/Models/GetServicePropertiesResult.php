<?php

namespace AzureOSS\Storage\Common\Models;

class GetServicePropertiesResult
{
    private $_serviceProperties;

    /**
     * Creates object from $parsedResponse.
     *
     * @internal
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @return \AzureOSS\Storage\Common\Models\GetServicePropertiesResult
     */
    public static function create(array $parsedResponse)
    {
        $result = new GetServicePropertiesResult();
        $result->setValue(ServiceProperties::create($parsedResponse));

        return $result;
    }

    /**
     * Gets service properties object.
     *
     * @return \AzureOSS\Storage\Common\Models\ServiceProperties
     */
    public function getValue()
    {
        return $this->_serviceProperties;
    }

    /**
     * Sets service properties object.
     *
     * @param ServiceProperties $serviceProperties object to use.
     */
    protected function setValue($serviceProperties)
    {
        $this->_serviceProperties = clone $serviceProperties;
    }
}
