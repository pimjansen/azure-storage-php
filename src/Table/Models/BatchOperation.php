<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Table\Internal\TableResources as Resources;

class BatchOperation
{
    private $_type;
    private $_params;

    /**
     * Sets operation type.
     *
     * @param string $type The operation type. Must be valid type.
     */
    public function setType($type)
    {
        Validate::isTrue(
            BatchOperationType::isValid($type),
            Resources::INVALID_BO_TYPE_MSG
        );

        $this->_type = $type;
    }

    /**
     * Gets operation type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Adds or sets parameter for the operation.
     *
     * @param string $name  The param name. Must be valid name.
     * @param mixed  $value The param value.
     */
    public function addParameter($name, $value)
    {
        Validate::isTrue(
            BatchOperationParameterName::isValid($name),
            Resources::INVALID_BO_PN_MSG
        );
        $this->_params[$name] = $value;
    }

    /**
     * Gets parameter value and if the name doesn't exist, return null.
     *
     * @param string $name The parameter name.
     */
    public function getParameter($name)
    {
        return Utilities::tryGetValue($this->_params, $name);
    }
}
