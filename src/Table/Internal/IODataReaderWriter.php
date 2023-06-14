<?php

namespace AzureOSS\Storage\Table\Internal;

interface IODataReaderWriter
{
    /**
     * Constructs JSON representation for table entry.
     *
     * @param string $name The name of the table.
     *
     * @return string
     */
    public function getTable($name);

    /**
     * Parses one table entry.
     *
     * @param string $body The HTTP response body.
     *
     * @return string
     */
    public function parseTable($body);

    /**
     * Constructs array of tables from HTTP response body.
     *
     * @param string $body The HTTP response body.
     *
     * @return array
     */
    public function parseTableEntries($body);

    /**
     * Constructs JSON representation for entity.
     *
     * @param \AzureOSS\Storage\Table\Models\Entity $entity The entity instance.
     *
     * @return string
     */
    public function getEntity(\AzureOSS\Storage\Table\Models\Entity $entity);

    /**
     * Constructs entity from HTTP response body.
     *
     * @param string $body The HTTP response body.
     *
     * @return \AzureOSS\Storage\Table\Models\Entity
     */
    public function parseEntity($body);

    /**
     * Constructs array of entities from HTTP response body.
     *
     * @param string $body The HTTP response body.
     *
     * @return array
     */
    public function parseEntities($body);
}
