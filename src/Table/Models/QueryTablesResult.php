<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Table\Internal\TableResources as Resources;

class QueryTablesResult
{
    use TableContinuationTokenTrait;

    private $_tables;

    /**
     * Creates new QueryTablesResult object
     *
     * @param array $headers The HTTP response headers
     * @param array $entries The table entriess
     *
     * @internal
     *
     * @return QueryTablesResult
     */
    public static function create(array $headers, array $entries)
    {
        $result = new QueryTablesResult();
        $headers = array_change_key_case($headers);

        $result->setTables($entries);

        $nextTableName = Utilities::tryGetValue(
            $headers,
            Resources::X_MS_CONTINUATION_NEXTTABLENAME
        );

        if ($nextTableName != null) {
            $result->setContinuationToken(
                new TableContinuationToken(
                    $nextTableName,
                    '',
                    '',
                    Utilities::getLocationFromHeaders($headers)
                )
            );
        }

        return $result;
    }

    /**
     * Gets tables
     *
     * @return array
     */
    public function getTables()
    {
        return $this->_tables;
    }

    /**
     * Sets tables
     *
     * @param array $tables value
     */
    protected function setTables(array $tables)
    {
        $this->_tables = $tables;
    }
}
