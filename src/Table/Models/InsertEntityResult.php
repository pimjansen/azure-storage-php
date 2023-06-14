<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Table\Internal\IODataReaderWriter;
use AzureOSS\Storage\Table\Internal\TableResources as Resources;

class InsertEntityResult
{
    private $entity;

    /**
     * Create InsertEntityResult object from HTTP response parts.
     *
     * @param string             $body            The HTTP response body.
     * @param array              $headers         The HTTP response headers.
     * @param IODataReaderWriter $odataSerializer The OData reader and writer.
     *
     * @internal
     *
     * @return InsertEntityResult
     */
    public static function create($body, $headers, $odataSerializer)
    {
        $result = new InsertEntityResult();
        $entity = $odataSerializer->parseEntity($body);
        $entity->setETag(Utilities::tryGetValue($headers, Resources::ETAG));
        $result->setEntity($entity);

        return $result;
    }

    /**
     * Gets table entity.
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Sets table entity.
     *
     * @param Entity $entity The table entity instance.
     */
    protected function setEntity($entity)
    {
        $this->entity = $entity;
    }
}
