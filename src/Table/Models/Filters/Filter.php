<?php

namespace AzureOSS\Storage\Table\Models\Filters;

class Filter
{
    /**
     * Apply and operation between two filters
     *
     * @param Filter $left  The left filter
     * @param Filter $right The right filter
     *
     * @return \AzureOSS\Storage\Table\Models\Filters\BinaryFilter
     */
    public static function applyAnd(Filter $left, Filter $right)
    {
        return new BinaryFilter($left, 'and', $right);
    }

    /**
     * Applies not operation on $operand
     *
     * @param Filter $operand The operand
     *
     * @return \AzureOSS\Storage\Table\Models\Filters\UnaryFilter
     */
    public static function applyNot(Filter $operand)
    {
        return new UnaryFilter('not', $operand);
    }

    /**
     * Apply or operation on the passed filers
     *
     * @param Filter $left  The left operand
     * @param Filter $right The right operand
     *
     * @return BinaryFilter
     */
    public static function applyOr(Filter $left, Filter $right)
    {
        return new BinaryFilter($left, 'or', $right);
    }

    /**
     * Apply eq operation on the passed filers
     *
     * @param Filter $left  The left operand
     * @param Filter $right The right operand
     *
     * @return BinaryFilter
     */
    public static function applyEq(Filter $left, Filter $right)
    {
        return new BinaryFilter($left, 'eq', $right);
    }

    /**
     * Apply ne operation on the passed filers
     *
     * @param Filter $left  The left operand
     * @param Filter $right The right operand
     *
     * @return BinaryFilter
     */
    public static function applyNe(Filter $left, Filter $right)
    {
        return new BinaryFilter($left, 'ne', $right);
    }

    /**
     * Apply ge operation on the passed filers
     *
     * @param Filter $left  The left operand
     * @param Filter $right The right operand
     *
     * @return BinaryFilter
     */
    public static function applyGe(Filter $left, Filter $right)
    {
        return new BinaryFilter($left, 'ge', $right);
    }

    /**
     * Apply gt operation on the passed filers
     *
     * @param Filter $left  The left operand
     * @param Filter $right The right operand
     *
     * @return BinaryFilter
     */
    public static function applyGt(Filter $left, Filter $right)
    {
        return new BinaryFilter($left, 'gt', $right);
    }

    /**
     * Apply lt operation on the passed filers
     *
     * @param Filter $left  The left operand
     * @param Filter $right The right operand
     *
     * @return BinaryFilter
     */
    public static function applyLt(Filter $left, Filter $right)
    {
        return new BinaryFilter($left, 'lt', $right);
    }

    /**
     * Apply le operation on the passed filers
     *
     * @param Filter $left  The left operand
     * @param Filter $right The right operand
     *
     * @return BinaryFilter
     */
    public static function applyLe(Filter $left, Filter $right)
    {
        return new BinaryFilter($left, 'le', $right);
    }

    /**
     * Apply constant filter on value.
     *
     * @param mixed  $value   The filter value
     * @param string $edmType The value EDM type.
     *
     * @return \AzureOSS\Storage\Table\Models\Filters\ConstantFilter
     */
    public static function applyConstant($value, $edmType = null)
    {
        return new ConstantFilter($edmType, $value);
    }

    /**
     * Apply propertyName filter on $value
     *
     * @param string $value The filter value
     *
     * @return \AzureOSS\Storage\Table\Models\Filters\PropertyNameFilter
     */
    public static function applyPropertyName($value)
    {
        return new PropertyNameFilter($value);
    }

    /**
     * Takes raw string filter
     *
     * @param string $value The raw string filter expression
     *
     * @return \AzureOSS\Storage\Table\Models\Filters\QueryStringFilter
     */
    public static function applyQueryString($value)
    {
        return new QueryStringFilter($value);
    }
}
