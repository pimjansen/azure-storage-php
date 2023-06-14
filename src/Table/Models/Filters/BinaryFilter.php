<?php

namespace AzureOSS\Storage\Table\Models\Filters;

class BinaryFilter extends Filter
{
    private $_operator;
    private $_left;
    private $_right;

    /**
     * Constructor.
     *
     * @param Filter $left     The left operand.
     * @param string $operator The operator.
     * @param Filter $right    The right operand.
     */
    public function __construct($left, $operator, $right)
    {
        $this->_left = $left;
        $this->_operator = $operator;
        $this->_right = $right;
    }

    /**
     * Gets operator
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->_operator;
    }

    /**
     * Gets left
     *
     * @return Filter
     */
    public function getLeft()
    {
        return $this->_left;
    }

    /**
     * Gets right
     *
     * @return Filter
     */
    public function getRight()
    {
        return $this->_right;
    }
}
