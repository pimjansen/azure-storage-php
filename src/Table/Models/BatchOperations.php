<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Table\Internal\TableResources as Resources;

class BatchOperations
{
    private $_operations;

    /**
     * Default constructor.
     */
    public function __construct()
    {
        $this->_operations = [];
    }

    /**
     * Gets the batch operations.
     *
     * @return array
     */
    public function getOperations()
    {
        return $this->_operations;
    }

    /**
     * Sets the batch operations.
     *
     * @param array $operations The batch operations.
     */
    public function setOperations(array $operations)
    {
        $this->_operations = [];
        foreach ($operations as $operation) {
            $this->addOperation($operation);
        }
    }

    /**
     * Adds operation to the batch operations.
     *
     * @param mixed $operation The operation to add.
     */
    public function addOperation($operation)
    {
        Validate::isTrue(
            $operation instanceof BatchOperation,
            Resources::INVALID_BO_TYPE_MSG
        );

        $this->_operations[] = $operation;
    }

    /**
     * Adds insertEntity operation.
     *
     * @param string $table  The table name.
     * @param Entity $entity The entity instance.
     */
    public function addInsertEntity($table, Entity $entity)
    {
        Validate::canCastAsString($table, 'table');
        Validate::notNullOrEmpty($entity, 'entity');

        $operation = new BatchOperation();
        $type = BatchOperationType::INSERT_ENTITY_OPERATION;
        $operation->setType($type);
        $operation->addParameter(BatchOperationParameterName::BP_TABLE, $table);
        $operation->addParameter(BatchOperationParameterName::BP_ENTITY, $entity);
        $this->addOperation($operation);
    }

    /**
     * Adds updateEntity operation.
     *
     * @param string $table  The table name.
     * @param Entity $entity The entity instance.
     */
    public function addUpdateEntity($table, Entity $entity)
    {
        Validate::canCastAsString($table, 'table');
        Validate::notNullOrEmpty($entity, 'entity');

        $operation = new BatchOperation();
        $type = BatchOperationType::UPDATE_ENTITY_OPERATION;
        $operation->setType($type);
        $operation->addParameter(BatchOperationParameterName::BP_TABLE, $table);
        $operation->addParameter(BatchOperationParameterName::BP_ENTITY, $entity);
        $this->addOperation($operation);
    }

    /**
     * Adds mergeEntity operation.
     *
     * @param string $table  The table name.
     * @param Entity $entity The entity instance.
     */
    public function addMergeEntity($table, Entity $entity)
    {
        Validate::canCastAsString($table, 'table');
        Validate::notNullOrEmpty($entity, 'entity');

        $operation = new BatchOperation();
        $type = BatchOperationType::MERGE_ENTITY_OPERATION;
        $operation->setType($type);
        $operation->addParameter(BatchOperationParameterName::BP_TABLE, $table);
        $operation->addParameter(BatchOperationParameterName::BP_ENTITY, $entity);
        $this->addOperation($operation);
    }

    /**
     * Adds insertOrReplaceEntity operation.
     *
     * @param string $table  The table name.
     * @param Entity $entity The entity instance.
     */
    public function addInsertOrReplaceEntity($table, Entity $entity)
    {
        Validate::canCastAsString($table, 'table');
        Validate::notNullOrEmpty($entity, 'entity');

        $operation = new BatchOperation();
        $type = BatchOperationType::INSERT_REPLACE_ENTITY_OPERATION;
        $operation->setType($type);
        $operation->addParameter(BatchOperationParameterName::BP_TABLE, $table);
        $operation->addParameter(BatchOperationParameterName::BP_ENTITY, $entity);
        $this->addOperation($operation);
    }

    /**
     * Adds insertOrMergeEntity operation.
     *
     * @param string $table  The table name.
     * @param Entity $entity The entity instance.
     */
    public function addInsertOrMergeEntity($table, Entity $entity)
    {
        Validate::canCastAsString($table, 'table');
        Validate::notNullOrEmpty($entity, 'entity');

        $operation = new BatchOperation();
        $type = BatchOperationType::INSERT_MERGE_ENTITY_OPERATION;
        $operation->setType($type);
        $operation->addParameter(BatchOperationParameterName::BP_TABLE, $table);
        $operation->addParameter(BatchOperationParameterName::BP_ENTITY, $entity);
        $this->addOperation($operation);
    }

    /**
     * Adds deleteEntity operation.
     *
     * @param string $table        The table name.
     * @param string $partitionKey The entity partition key.
     * @param string $rowKey       The entity row key.
     * @param string $etag         The entity etag.
     */
    public function addDeleteEntity($table, $partitionKey, $rowKey, $etag = null)
    {
        Validate::canCastAsString($table, 'table');
        Validate::isTrue(null !== $partitionKey, Resources::NULL_TABLE_KEY_MSG);
        Validate::isTrue(null !== $rowKey, Resources::NULL_TABLE_KEY_MSG);

        $operation = new BatchOperation();
        $type = BatchOperationType::DELETE_ENTITY_OPERATION;
        $operation->setType($type);
        $operation->addParameter(BatchOperationParameterName::BP_TABLE, $table);
        $operation->addParameter(BatchOperationParameterName::BP_ROW_KEY, $rowKey);
        $operation->addParameter(BatchOperationParameterName::BP_ETAG, $etag);
        $operation->addParameter(
            BatchOperationParameterName::BP_PARTITION_KEY,
            $partitionKey
        );
        $this->addOperation($operation);
    }
}
