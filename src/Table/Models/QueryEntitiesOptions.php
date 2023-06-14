<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Table\Internal\AcceptOptionTrait;

class QueryEntitiesOptions extends TableServiceOptions
{
    use TableContinuationTokenTrait;
    use AcceptOptionTrait;

    private $query;

    /**
     * Constructs new QueryEntitiesOptions object.
     */
    public function __construct()
    {
        parent::__construct();
        $this->query = new Query();
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
     * Sets query.
     *
     * You can either sets the whole query *or* use the individual query functions
     * like (setTop).
     *
     * @param Query $query The query instance.
     */
    public function setQuery(Query $query)
    {
        $this->query = $query;
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
     * You can either use this individual function or use setQuery to set the whole
     * query object.
     *
     * @param Filters\Filter $filter value.
     */
    public function setFilter(Filters\Filter $filter)
    {
        $this->query->setFilter($filter);
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
     * You can either use this individual function or use setQuery to set the whole
     * query object.
     *
     * @param int $top value.
     */
    public function setTop($top)
    {
        $this->query->setTop($top);
    }

    /**
     * Adds a field to select fields.
     *
     * You can either use this individual function or use setQuery to set the whole
     * query object.
     *
     * @param string $field The value of the field.
     */
    public function addSelectField($field)
    {
        $this->query->addSelectField($field);
    }

    /**
     * Gets selectFields.
     *
     * @return array
     */
    public function getSelectFields()
    {
        return $this->query->getSelectFields();
    }

    /**
     * Sets selectFields.
     *
     * You can either use this individual function or use setQuery to set the whole
     * query object.
     *
     * @param array $selectFields value.
     */
    public function setSelectFields(array $selectFields = null)
    {
        $this->query->setSelectFields($selectFields);
    }
}
