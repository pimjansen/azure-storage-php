<?php

namespace AzureOSS\Storage\Table\Models\Filters;

class UnaryFilter extends Filter
{
    private $_operator;
    private $_operand;

    /**
     * Constructor.
     *
     * @param string $operator The operator.
     * @param Filter $operand  The operand filter.
     */
    public function __construct($operator, Filter $operand = null)
    {
        $this->_operand = $operand;
        $this->_operator = $operator;
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
     * Gets operand
     *
     * @return Filter
     */
    public function getOperand()
    {
        return $this->_operand;
    }
}
