<?php

namespace AzureOSS\Storage\Table\Models;

class GetTableResult
{
    private $_name;

    /**
     * Creates GetTableResult from HTTP response body.
     *
     * @param string             $body            The HTTP response body.
     * @param IODataReaderWriter $odataSerializer The OData reader and writer.
     *
     * @internal
     *
     * @return GetTableResult
     */
    public static function create($body, $odataSerializer)
    {
        $result = new GetTableResult();
        $name = $odataSerializer->parseTable($body);
        $result->setName($name);

        return $result;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets the name.
     *
     * @param string $name The table name.
     */
    protected function setName($name)
    {
        $this->_name = $name;
    }
}
