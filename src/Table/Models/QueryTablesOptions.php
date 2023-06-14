<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Table\Internal\AcceptOptionTrait;

class QueryTablesOptions extends TableServiceOptions
{
    use TableContinuationTokenTrait;
    use AcceptOptionTrait;

    private $query;
    private $prefix;

    /**
     * Constructs new QueryTablesOptions object.
     */
    public function __construct()
    {
        parent::__construct();
        $this->query = new Query();
    }

    /**
     * Gets prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Sets prefix
     *
     * @param string $prefix value
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Gets top.
     *
     * @return int
     */
    public function getTop()
    {
        return $this->query->getTop();
    }

    /**
     * Sets top.
     *
     * @param int $top value.
     */
    public function setTop($top)
    {
        $this->query->setTop($top);
    }

    /**
     * Gets query.
     *
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Gets filter.
     *
     * @return Filters\Filter
     */
    public function getFilter()
    {
        return $this->query->getFilter();
    }

    /**
     * Sets filter.
     *
     * @param Filters\Filter $filter value.
     */
    public function setFilter(Filters\Filter $filter)
    {
        $this->query->setFilter($filter);
    }

    /**
     * Sets selectFields.
     *
     * You can either use this individual function or use setQuery to set the
     * whole query object.
     *
     * @param array $selectFields value.
     */
    public function setSelectFields(array $selectFields = null)
    {
        $this->query->setSelectFields($selectFields);
    }
}
