<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Common\LocationMode;
use AzureOSS\Storage\Common\Models\ServiceOptions;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class FileServiceOptions extends ServiceOptions
{
    public function setLocationMode($locationMode)
    {
        Validate::canCastAsString($locationMode, 'locationMode');
        Validate::isTrue(
            $locationMode == LocationMode::PRIMARY_ONLY,
            Resources::FILE_LOCATION_IS_PRIMARY_ONLY
        );

        $this->locationMode = $locationMode;
    }
}
