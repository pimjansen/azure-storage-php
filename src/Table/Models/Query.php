<?php

namespace AzureOSS\Storage\Table\Models;

class Query
{
    private $_selectFields;
    private $_filter;
    private $_top;

    /**
     * Gets filter.
     *
     * @return Filters\Filter
     */
    public function getFilter()
    {
        return $this->_filter;
    }

    /**
     * Sets filter.
     *
     * @param Filters\Filter $filter value.
     */
    public function setFilter($filter)
    {
        $this->_filter = $filter;
    }

    /**
     * Gets top.
     *
     * @return int
     */
    public function getTop()
    {
        return $this->_top;
    }

    /**
     * Sets top.
     *
     * @param int $top value.
     */
    public function setTop($top)
    {
        $this->_top = $top;
    }

    /**
     * Adds a field to select fields.
     *
     * @param string $field The value of the field.
     */
    public function addSelectField($field)
    {
        $this->_selectFields[] = $field;
    }

    /**
     * Gets selectFields.
     *
     * @return array
     */
    public function getSelectFields()
    {
        return $this->_selectFields;
    }

    /**
     * Sets selectFields.
     *
     * @param array $selectFields value.
     */
    public function setSelectFields(array $selectFields = null)
    {
        $this->_selectFields = $selectFields;
    }
}
