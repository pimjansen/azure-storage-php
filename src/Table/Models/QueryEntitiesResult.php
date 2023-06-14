<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Table\Internal\TableResources as Resources;

class QueryEntitiesResult
{
    use TableContinuationTokenTrait;

    private $_entities;

    /**
     * Creates new QueryEntitiesResult instance.
     *
     * @param array $headers  The HTTP response headers.
     * @param array $entities The entities.
     *
     * @internal
     *
     * @return QueryEntitiesResult
     */
    public static function create(array $headers, array $entities)
    {
        $result = new QueryEntitiesResult();
        $headers = array_change_key_case($headers);
        $nextPK = Utilities::tryGetValue(
            $headers,
            Resources::X_MS_CONTINUATION_NEXTPARTITIONKEY
        );
        $nextRK = Utilities::tryGetValue(
            $headers,
            Resources::X_MS_CONTINUATION_NEXTROWKEY
        );

        // Note that in some instances, x-ms-continuation-NextRowKey ($nextRK) may be null.
        // Ref: https://docs.microsoft.com/en-us/rest/api/storageservices/query-timeout-and-pagination
        if ($nextPK != null) {
            $result->setContinuationToken(
                new TableContinuationToken(
                    '',
                    $nextPK,
                    $nextRK,
                    Utilities::getLocationFromHeaders($headers)
                )
            );
        }

        $result->setEntities($entities);

        return $result;
    }

    /**
     * Gets entities.
     *
     * @return array
     */
    public function getEntities()
    {
        return $this->_entities;
    }

    /**
     * Sets entities.
     *
     * @param array $entities The entities array.
     */
    protected function setEntities(array $entities)
    {
        $this->_entities = $entities;
    }
}
