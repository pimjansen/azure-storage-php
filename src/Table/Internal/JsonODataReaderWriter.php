<?php

namespace AzureOSS\Storage\Table\Internal;

use AzureOSS\Storage\Table\Internal\TableResources as Resources;
use AzureOSS\Storage\Table\Models\EdmType;
use AzureOSS\Storage\Table\Models\Entity;

class JsonODataReaderWriter implements IODataReaderWriter
{
    /**
     * Constructs JSON representation for table entry.
     *
     * @param string $name The name of the table.
     *
     * @return string
     */
    public function getTable($name)
    {
        return json_encode([Resources::JSON_TABLE_NAME => $name]);
    }

    /**
     * Parses one table entry.
     *
     * @param mixed $body The HTTP response body.
     *
     * @return string
     */
    public function parseTable($body)
    {
        $table = json_decode($body, true);
        return $table[Resources::JSON_TABLE_NAME];
    }

    /**
     * Constructs array of tables from HTTP response body.
     *
     * @param string $body The HTTP response body.
     *
     * @return array
     */
    public function parseTableEntries($body)
    {
        $tables = [];
        $result = json_decode($body, true);

        $rawEntries = $result[Resources::JSON_VALUE];

        foreach ($rawEntries as $entry) {
            $tables[] = $entry[Resources::JSON_TABLE_NAME];
        }

        return $tables;
    }

    /**
     * Constructs JSON representation for entity.
     *
     * @param Entity $entity The entity instance.
     *
     * @return string
     */
    public function getEntity(Entity $entity)
    {
        $entityProperties = $entity->getProperties();
        $properties = [];

        foreach ($entityProperties as $name => $property) {
            $edmType = $property->getEdmType();
            $edmValue = $property->getValue();

            if (null === $edmValue) {
                // No @odata.type JSON property needed for null value
                $properties[$name] = null;
            } else {
                if (null === $edmType) {
                    $edmType = EdmType::propertyType($edmValue);
                }

                $value = EdmType::serializeValue($edmType, $edmValue);
                $properties[$name] = $value;

                if (EdmType::typeRequired($edmType)) {
                    $properties[$name . Resources::JSON_ODATA_TYPE_SUFFIX] = $edmType;
                }
            }
        }

        return json_encode($properties);
    }

    /**
     * Constructs entity from HTTP response body.
     *
     * @param string $body The HTTP response body.
     *
     * @return Entity
     */
    public function parseEntity($body)
    {
        $rawEntity = json_decode($body, true);
        return $this->parseOneEntity($rawEntity);
    }

    /**
     * Constructs array of entities from HTTP response body.
     *
     * @param string $body The HTTP response body.
     *
     * @return array
     */
    public function parseEntities($body)
    {
        $rawEntities = json_decode($body, true);
        $entities = [];

        foreach ($rawEntities[Resources::JSON_VALUE] as $rawEntity) {
            $entities[] = $this->parseOneEntity($rawEntity);
        }

        return $entities;
    }

    private function parseOneEntity($rawEntity)
    {
        $entity = new Entity();

        if (array_key_exists(Resources::JSON_TIMESTAMP, $rawEntity)) {
            $rawTimestamp = $rawEntity[Resources::JSON_TIMESTAMP];
            $timestamp = EdmType::unserializeQueryValue(EdmType::DATETIME, $rawTimestamp);

            $entity->addProperty(
                Resources::JSON_TIMESTAMP,
                EdmType::DATETIME,
                $timestamp
            );
        }

        // Make sure etag is set
        if (array_key_exists(Resources::JSON_ODATA_ETAG, $rawEntity)) {
            $etag = (string) $rawEntity[Resources::JSON_ODATA_ETAG];
        } else {
            $etag = null;
        }
        $entity->setETag($etag);

        foreach ($rawEntity as $key => $value) {
            if ($key === Resources::JSON_TIMESTAMP) {
                continue;
            }

            // Ignore keys end with Resources::JSON_ODATA_TYPE_SUFFIX
            if (
                strlen($key) > strlen(Resources::JSON_ODATA_TYPE_SUFFIX)
                && strpos(
                    $key,
                    Resources::JSON_ODATA_TYPE_SUFFIX,
                    strlen($key) - strlen(Resources::JSON_ODATA_TYPE_SUFFIX)
                ) !== false
            ) {
                continue;
            }

            if (strpos($key, 'odata.') === 0) {
                continue;
            }

            if (array_key_exists($key . Resources::JSON_ODATA_TYPE_SUFFIX, $rawEntity)) {
                $edmType = $rawEntity[$key . Resources::JSON_ODATA_TYPE_SUFFIX];
            } elseif (in_array($key, [Resources::JSON_PARTITION_KEY, Resources::JSON_ROW_KEY], true)) {
                $edmType = EdmType::STRING;
            } else {
                // Guess the property type
                $edmType = EdmType::propertyType($value);
            }
            //Store the raw value of the string representation.
            $rawValue = \is_string($value) ? $value : '';
            $value = EdmType::unserializeQueryValue((string) $edmType, $value);
            $entity->addProperty(
                (string) $key,
                (string) $edmType,
                $value,
                $rawValue
            );
        }

        return $entity;
    }
}
