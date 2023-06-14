<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Internal\MetadataTrait;

class GetBlobMetadataResult
{
    use MetadataTrait;

    /**
     * Creates the instance from the parsed headers.
     *
     * @param array $parsed Parsed headers
     *
     * @return GetBlobMetadataResult
     */
    public static function create(array $parsed)
    {
        return static::createMetadataResult($parsed);
    }
}
