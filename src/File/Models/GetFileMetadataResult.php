<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\MetadataTrait;

class GetFileMetadataResult
{
    use MetadataTrait;

    /**
     * Creates the instance from the parsed headers.
     *
     * @param array $parsed Parsed headers
     *
     * @return GetFileMetadataResult
     */
    public static function create(array $parsed)
    {
        return static::createMetadataResult($parsed);
    }
}
