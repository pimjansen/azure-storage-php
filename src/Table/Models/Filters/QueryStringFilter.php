<?php

namespace AzureOSS\Storage\Table\Models\Filters;

class QueryStringFilter extends Filter
{
    /**
     * @var string
     */
    private $_queryString;

    /**
     * Constructor.
     *
     * @param string $queryString The OData query string.
     */
    public function __construct($queryString)
    {
        $this->_queryString = $queryString;
    }

    /**
     * Gets raw string filter
     *
     * @return string
     */
    public function getQueryString()
    {
        return $this->_queryString;
    }
}
