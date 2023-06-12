<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @see      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Tests\Functional\Table;

use MicrosoftAzure\Storage\Common\Models\Logging;
use MicrosoftAzure\Storage\Common\Models\Metrics;
use MicrosoftAzure\Storage\Common\Models\RetentionPolicy;
use MicrosoftAzure\Storage\Common\Models\ServiceProperties;
use MicrosoftAzure\Storage\Table\Models\DeleteEntityOptions;
use MicrosoftAzure\Storage\Table\Models\EdmType;
use MicrosoftAzure\Storage\Table\Models\Entity;
use MicrosoftAzure\Storage\Table\Models\Filters\BinaryFilter;
use MicrosoftAzure\Storage\Table\Models\Filters\ConstantFilter;
use MicrosoftAzure\Storage\Table\Models\Filters\Filter;
use MicrosoftAzure\Storage\Table\Models\Filters\PropertyNameFilter;
use MicrosoftAzure\Storage\Table\Models\Filters\QueryStringFilter;
use MicrosoftAzure\Storage\Table\Models\Filters\UnaryFilter;
use MicrosoftAzure\Storage\Table\Models\Property;
use MicrosoftAzure\Storage\Table\Models\Query;
use MicrosoftAzure\Storage\Table\Models\QueryEntitiesOptions;
use MicrosoftAzure\Storage\Table\Models\QueryTablesOptions;
use MicrosoftAzure\Storage\Table\Models\TableServiceOptions;

class TableServiceFunctionalOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testCheckTableServiceOptions()
    {
        $options = new TableServiceOptions();
        self::assertNotNull($options, 'Default TableServiceOptions');
    }

    public function testCheckRetentionPolicy()
    {
        $rp = new RetentionPolicy();
        self::assertNull($rp->getDays(), 'Default RetentionPolicy->getDays should be null');
        self::assertNull($rp->getEnabled(), 'Default RetentionPolicy->getEnabled should be null');
        $rp->setDays(10);
        $rp->setEnabled(true);
        self::assertEquals(10, $rp->getDays(), 'Set RetentionPolicy->getDays should be 10');
        self::assertTrue($rp->getEnabled(), 'Set RetentionPolicy->getEnabled should be true');
    }

    public function testCheckLogging()
    {
        $rp = new RetentionPolicy();

        $l = new Logging();
        self::assertNull($l->getRetentionPolicy(), 'Default Logging->getRetentionPolicy should be null');
        self::assertNull($l->getVersion(), 'Default Logging->getVersion should be null');
        self::assertNull($l->getDelete(), 'Default Logging->getDelete should be null');
        self::assertNull($l->getRead(), 'Default Logging->getRead should be false');
        self::assertNull($l->getWrite(), 'Default Logging->getWrite should be false');
        $l->setRetentionPolicy($rp);
        $l->setVersion('2.0');
        $l->setDelete(true);
        $l->setRead(true);
        $l->setWrite(true);

        self::assertEquals($rp, $l->getRetentionPolicy(), 'Set Logging->getRetentionPolicy');
        self::assertEquals('2.0', $l->getVersion(), 'Set Logging->getVersion');
        self::assertTrue($l->getDelete(), 'Set Logging->getDelete should be true');
        self::assertTrue($l->getRead(), 'Set Logging->getRead should be true');
        self::assertTrue($l->getWrite(), 'Set Logging->getWrite should be true');
    }

    public function testCheckMetrics()
    {
        $rp = new RetentionPolicy();

        $m = new Metrics();
        self::assertNull($m->getRetentionPolicy(), 'Default Metrics->getRetentionPolicy should be null');
        self::assertNull($m->getVersion(), 'Default Metrics->getVersion should be null');
        self::assertNull($m->getEnabled(), 'Default Metrics->getEnabled should be false');
        self::assertNull($m->getIncludeAPIs(), 'Default Metrics->getIncludeAPIs should be null');
        $m->setRetentionPolicy($rp);
        $m->setVersion('2.0');
        $m->setEnabled(true);
        $m->setIncludeAPIs(true);
        self::assertEquals($rp, $m->getRetentionPolicy(), 'Set Metrics->getRetentionPolicy');
        self::assertEquals('2.0', $m->getVersion(), 'Set Metrics->getVersion');
        self::assertTrue($m->getEnabled(), 'Set Metrics->getEnabled should be true');
        self::assertTrue($m->getIncludeAPIs(), 'Set Metrics->getIncludeAPIs should be true');
    }

    public function testCheckServiceProperties()
    {
        $l = new Logging();
        $m = new Metrics();

        $sp = new ServiceProperties();
        self::assertNull($sp->getLogging(), 'Default ServiceProperties->getLogging should not be null');
        self::assertNull($sp->getHourMetrics(), 'Default ServiceProperties->getHourMetrics should not be null');

        $sp->setLogging($l);
        $sp->setHourMetrics($m);
        self::assertEquals($sp->getLogging(), $l, 'Set ServiceProperties->getLogging');
        self::assertEquals($sp->getHourMetrics(), $m, 'Set ServiceProperties->getHourMetrics');
    }

    public function testCheckQueryTablesOptions()
    {
        $options = new QueryTablesOptions();
        $nextTableName = 'foo';
        $filter = new Filter();

        self::assertEquals('', $options->getNextTableName(), 'Default QueryTablesOptions->getNextTableName');
        self::assertNotNull($options->getQuery(), 'Default QueryTablesOptions->getQuery');
        $options->setNextTableName($nextTableName);
        $options->setFilter($filter);
        $options->setTop(10);
        self::assertEquals($nextTableName, $options->getNextTableName(), 'Set QueryTablesOptions->getNextTableName');
        self::assertEquals($filter, $options->getFilter(), 'Set QueryTablesOptions->getFilter');
        self::assertEquals($filter, $options->getQuery()->getFilter(), 'Set QueryTablesOptions->getQuery->getFilter');
        self::assertEquals(10, $options->getTop(), 'Set QueryTablesOptions->getTop');
        self::assertEquals(10, $options->getQuery()->getTop(), 'Set QueryTablesOptions->getQuery->getTop');
    }

    public function testCheckDeleteEntityOptions()
    {
        $options = new DeleteEntityOptions();
        $etag = 'foo';

        self::assertNull($options->getETag(), 'Default DeleteEntityOptions->getETag');
        $options->setETag($etag);
        self::assertEquals($etag, $options->getETag(), 'Set DeleteEntityOptions->getETag');
    }

    public function testCheckQueryEntitiesOptions()
    {
        $options = new QueryEntitiesOptions();
        $query = new Query();
        $nextPartitionKey = 'aaa';
        $nextRowKey = 'bbb';

        self::assertEquals('', $options->getNextPartitionKey(), 'Default QueryEntitiesOptions->getNextPartitionKey');
        self::assertEquals('', $options->getNextRowKey(), 'Default QueryEntitiesOptions->getNextRowKey');
        self::assertNotNull($options->getQuery(), 'Default QueryEntitiesOptions->getQuery');
        $options->setNextPartitionKey($nextPartitionKey);
        $options->setNextRowKey($nextRowKey);
        $options->setQuery($query);
        self::assertEquals($nextPartitionKey, $options->getNextPartitionKey(), 'Set QueryEntitiesOptions->getNextPartitionKey');
        self::assertEquals($nextRowKey, $options->getNextRowKey(), 'Set QueryEntitiesOptions->getNextRowKey');
        self::assertEquals($query, $options->getQuery(), 'Set QueryEntitiesOptions->getQuery');

        $options->addSelectField('bar');
        $options->addSelectField('baz');
        self::assertNotNull($options->getSelectFields(), 'Add $options->getSelectFields');
        self::assertNotNull($options->getQuery()->getSelectFields(), 'Add $options->getQuery->getSelectFields');
        self::assertCount(2, $options->getSelectFields(), 'Add $options->getSelectFields->size');
        self::assertCount(2, $options->getQuery()->getSelectFields(), 'Add $options->getQuery->getSelectFields->size');

        $filter = Filter::applyConstant('foo', EdmType::STRING);
        $options->setFilter($filter);
        $options->setSelectFields(null);
        $options->setTop(TableServiceFunctionalTestData::INT_MAX_VALUE);

        self::assertEquals($filter, $options->getFilter(), 'Set $options->getFilter');
        self::assertEquals($filter, $options->getQuery()->getFilter(), 'Set $options->getQuery->getFilter');
        self::assertNull($options->getSelectFields(), 'Set $options->getSelectFields');
        self::assertNull($options->getQuery()->getSelectFields(), 'Set $options->getQuery->getSelectFields');
        self::assertEquals(TableServiceFunctionalTestData::INT_MAX_VALUE, $options->getTop(), 'Set $options->getTop');
        self::assertEquals(TableServiceFunctionalTestData::INT_MAX_VALUE, $options->getQuery()->getTop(), 'Set $options->getQuery->getTop');
    }

    public function testCheckQuery()
    {
        $query = new Query();
        self::assertNull($query->getFilter(), 'Default Query->getFilter');
        self::assertNull($query->getSelectFields(), 'Default Query->getSelectFields');
        self::assertNull($query->getTop(), 'Default Query->getTop');

        $query->addSelectField('bar');
        $query->addSelectField('baz');
        self::assertNotNull($query->getSelectFields(), 'Add Query->getSelectFields');
        self::assertCount(2, $query->getSelectFields(), 'Add Query->getSelectFields->size');

        $filter = Filter::applyConstant('foo', EdmType::STRING);
        $query->setFilter($filter);
        $query->setSelectFields(null);
        $query->setTop(TableServiceFunctionalTestData::INT_MAX_VALUE);

        self::assertEquals($filter, $query->getFilter(), 'Set Query->getFilter');
        self::assertNull($query->getSelectFields(), 'Set Query->getSelectFields');
        self::assertEquals(TableServiceFunctionalTestData::INT_MAX_VALUE, $query->getTop(), 'Set Query->getTop');
    }

    public function testCheckFilter()
    {
        $filter = new Filter();
        self::assertNotNull($filter, 'Default $filter');
    }

    public function testCheckBinaryFilter()
    {
        $filter = new BinaryFilter(null, null, null);
        self::assertNotNull($filter, 'Default $filter');

        self::assertNull($filter->getLeft(), 'Default BinaryFilter->getFilter');
        self::assertNull($filter->getOperator(), 'Default BinaryFilter->getOperator');
        self::assertNull($filter->getRight(), 'Default BinaryFilter->getRight');

        $left = new UnaryFilter(null, null);
        $operator = 'foo';
        $right = new ConstantFilter(null, EdmType::STRING);

        $filter = new BinaryFilter($left, $operator, $right);

        self::assertEquals($left, $filter->getLeft(), 'Set BinaryFilter->getLeft');
        self::assertEquals($operator, $filter->getOperator(), 'Set BinaryFilter->getOperator');
        self::assertEquals($right, $filter->getRight(), 'Set BinaryFilter->getRight');

        // Now check the factory.
        $filter = Filter::applyAnd($left, $right);
        self::assertEquals($left, $filter->getLeft(), 'and factory BinaryFilter->getLeft');
        self::assertEquals('and', $filter->getOperator(), 'and factory BinaryFilter->getOperator');
        self::assertEquals($right, $filter->getRight(), 'and factory BinaryFilter->getRight');

        $filter = Filter::applyEq($left, $right);
        self::assertEquals($left, $filter->getLeft(), 'eq factory BinaryFilter->getLeft');
        self::assertEquals('eq', $filter->getOperator(), 'eq factory BinaryFilter->getOperator');
        self::assertEquals($right, $filter->getRight(), 'eq factory BinaryFilter->getRight');

        $filter = Filter::applyGe($left, $right);
        self::assertEquals($left, $filter->getLeft(), 'ge factory BinaryFilter->getLeft');
        self::assertEquals('ge', $filter->getOperator(), 'ge factory BinaryFilter->getOperator');
        self::assertEquals($right, $filter->getRight(), 'ge factory BinaryFilter->getRight');

        $filter = Filter::applyGt($left, $right);
        self::assertEquals($left, $filter->getLeft(), 'gt factory BinaryFilter->getLeft');
        self::assertEquals('gt', $filter->getOperator(), 'gt factory BinaryFilter->getOperator');
        self::assertEquals($right, $filter->getRight(), 'gt factory BinaryFilter->getRight');

        $filter = Filter::applyLe($left, $right);
        self::assertEquals($left, $filter->getLeft(), 'le factory BinaryFilter->getLeft');
        self::assertEquals('le', $filter->getOperator(), 'le factory BinaryFilter->getOperator');
        self::assertEquals($right, $filter->getRight(), 'le factory BinaryFilter->getRight');

        $filter = Filter::applyLt($left, $right);
        self::assertEquals($left, $filter->getLeft(), 'lt factory BinaryFilter->getLeft');
        self::assertEquals('lt', $filter->getOperator(), 'lt factory BinaryFilter->getOperator');
        self::assertEquals($right, $filter->getRight(), 'lt factory BinaryFilter->getRight');

        $filter = Filter::applyNe($left, $right);
        self::assertEquals($left, $filter->getLeft(), 'ne factory BinaryFilter->getLeft');
        self::assertEquals('ne', $filter->getOperator(), 'ne factory BinaryFilter->getOperator');
        self::assertEquals($right, $filter->getRight(), 'ne factory BinaryFilter->getRight');

        $filter = Filter::applyOr($left, $right);
        self::assertEquals($left, $filter->getLeft(), 'or factory BinaryFilter->getLeft');
        self::assertEquals('or', $filter->getOperator(), 'or factory BinaryFilter->getOperator');
        self::assertEquals($right, $filter->getRight(), 'or factory BinaryFilter->getRight');
    }

    public function testCheckConstantFilter()
    {
        $filter = new ConstantFilter(EdmType::STRING, null);
        self::assertNotNull($filter, 'Default $filter');

        self::assertNull($filter->getValue(), 'Default ConstantFilter->getValue');

        $value = 'foo';
        $filter = new ConstantFilter(EdmType::STRING, $value);

        self::assertEquals($value, $filter->getValue(), 'Set ConstantFilter->getValue');

        // Now check the factory.
        $value = 'bar';
        $filter = Filter::applyConstant($value, EdmType::STRING);
        self::assertEquals($value, $filter->getValue(), 'constant factory ConstantFilter->getValue');
    }

    public function testCheckPropertyNameFilter()
    {
        $filter = new PropertyNameFilter(null);
        self::assertNotNull($filter, 'Default $filter');

        self::assertNull($filter->getPropertyName(), 'Default PropertyNameFilter->getPropertyName');

        $propertyName = 'foo';
        $filter = new PropertyNameFilter($propertyName);
        self::assertEquals($propertyName, $filter->getPropertyName(), 'Set PropertyNameFilter->getPropertyName');

        // Now check the factory.
        $PropertyName = 'bar';
        $filter = Filter::applyPropertyName($propertyName);
        self::assertEquals($propertyName, $filter->getPropertyName(), 'PropertyName factory PropertyNameFilter->getPropertyName');
    }

    public function testCheckQueryStringFilter()
    {
        $filter = new QueryStringFilter(null);
        self::assertNotNull($filter, 'Default $filter');

        self::assertNull($filter->getQueryString(), 'Default QueryStringFilter->getQueryString');

        $queryString = 'foo';
        $filter = new QueryStringFilter($queryString);
        self::assertEquals($queryString, $filter->getQueryString(), 'Set QueryStringFilter->getQueryString');

        // Now check the factory.
        $queryString = 'bar';
        $filter = Filter::applyQueryString($queryString);
        self::assertEquals($queryString, $filter->getQueryString(), 'QueryString factory QueryStringFilter->getQueryString');
    }

    public function testCheckUnaryFilter()
    {
        $filter = new UnaryFilter(null, null);
        self::assertNotNull($filter, 'Default $filter');

        self::assertNull($filter->getOperand(), 'Default UnaryFilter->getOperand');
        self::assertNull($filter->getOperator(), 'Default UnaryFilter->getOperator');

        $operand = new BinaryFilter(null, null, null);
        $operator = 'foo';
        $filter = new UnaryFilter($operator, $operand);
        self::assertEquals($operand, $filter->getOperand(), 'Set UnaryFilter->getOperand');
        self::assertEquals($operator, $filter->getOperator(), 'Set UnaryFilter->getOperator');

        // Now check the factory.
        $operand = new ConstantFilter(EdmType::STRING, null);
        $filter = Filter::applyNot($operand);
        self::assertEquals($operand, $filter->getOperand(), 'Unary factory UnaryFilter->getOperand');
        self::assertEquals('not', $filter->getOperator(), 'Unary factory UnaryFilter->getOperator');
    }

    public function testCheckProperty()
    {
        $property = new Property();
        $maxv = TableServiceFunctionalTestData::INT_MAX_VALUE;
        $edmType = EdmType::STRING;
        self::assertNotNull($property, 'Default Property');
        self::assertNull($property->getValue(), 'Default Property->getValue');
        self::assertNull($property->getEdmType(), 'Default Property->getEdmType');
        $property->setValue($maxv);
        $property->setEdmType($edmType);
        self::assertEquals($maxv, $property->getValue(), 'Set Property->getValue');
        self::assertEquals($edmType, $property->getEdmType(), 'Set Property->getEdmType');
    }

    public function testCheckEntity()
    {
        $entity = new Entity();
        $etag = 'custom $etag';
        $partitionKey = 'custom partiton key';
        $rowKey = 'custom rowkey';
        $dates = TableServiceFunctionalTestData::getInterestingGoodDates();
        $timestamp = $dates[1];

        $property = new Property();
        $property->setEdmType(EdmType::INT32);
        $property->setValue(1234);
        $name = 'my name';
        $edmType = EdmType::STRING;
        $value = 'my value';

        $properties = [];
        $properties['goo'] = new Property();
        $properties['moo'] = new Property();

        self::assertNotNull($entity, 'Default Entity');
        self::assertNull($entity->getProperties(), 'Default Entity->getProperties');
        self::assertNull($entity->getETag(), 'Default Entity->getETag');
        self::assertNull($entity->getPartitionKey(), 'Default Entity->getPartitionKey');
        self::assertNull($entity->getRowKey(), 'Default Entity->getRowKey');
        self::assertNull($entity->getTimestamp(), 'Default Entity->getTimestamp');
        self::assertNull($entity->getProperty('foo'), 'Default Entity->getProperty(\'foo\')');
        self::assertNull($entity->getPropertyValue('foo'), 'Default Entity->tryGtPropertyValue(\'foo\')');

        // Now set some things.
        $entity->setETag($etag);
        $entity->setPartitionKey($partitionKey);
        $entity->setRowKey($rowKey);
        $entity->setTimestamp($timestamp);

        self::assertEquals($etag, $entity->getETag(), 'Default Entity->getETag');
        self::assertEquals($partitionKey, $entity->getPartitionKey(), 'Default Entity->getPartitionKey');
        self::assertEquals($rowKey, $entity->getRowKey(), 'Default Entity->getRowKey');
        self::assertEquals($timestamp, $entity->getTimestamp(), 'Default Entity->getTimestamp');

        $entity->setProperty($name, $property);
        self::assertEquals($property, $entity->getProperty($name), 'Default Entity->getProperty(\'' . $name . '\')');

        $entity->addProperty($name, $edmType, $value);
        self::assertEquals($value, $entity->getPropertyValue($name), 'Default Entity->getPropertyValue(\'' . $name . '\')');
        self::assertEquals($edmType, $entity->getProperty($name)->getEdmType(), 'Default Entity->getProperty(\'' . $name . '\')->getEdmType');
        self::assertEquals($value, $entity->getProperty($name)->getValue(), 'Default Entity->getProperty(\'' . $name . '\')->getValue');
        self::assertNotEquals($entity->getProperty($name), $property, 'Default Entity->getProperty(\'' . $name . '\') changed');

        $entity->setProperties($properties);
        self::assertNotNull($entity->getProperties(), 'Default Entity->getProperties');
        self::assertEquals($properties, $entity->getProperties(), 'Default Entity->getProperties');
    }
}
