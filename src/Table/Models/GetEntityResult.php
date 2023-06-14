<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Table\Internal\IODataReaderWriter;

class GetEntityResult
{
    private $_entity;

    /**
     * Gets table entity.
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->_entity;
    }

    /**
     * Sets table entity.
     *
     * @param Entity $entity The table entity instance.
     */
    protected function setEntity($entity)
    {
        $this->_entity = $entity;
    }

    /**
     * Create GetEntityResult object from HTTP response parts.
     *
     * @param string $body The HTTP response body.
     *
     * @internal
     *
     * @return GetEntityResult
     */
    public static function create($body, IODataReaderWriter $serializer)
    {
        $result = new GetEntityResult();
        $result->setEntity($serializer->parseEntity($body));

        return $result;
    }
}
