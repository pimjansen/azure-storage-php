<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class GetShareStatsResult
{
    /**
     * The approximate size of the data stored on the share, rounded up to the
     * nearest gigabyte. Note that this value may not include all recently
     * created or recently resized files.
     *
     * @var int
     */
    private $shareUsage;

    /**
     * Gets file shareUsage.
     *
     * @return int
     */
    public function getShareUsage()
    {
        return $this->shareUsage;
    }

    /**
     * Sets file shareUsage.
     *
     * @param int $shareUsage value.
     */
    protected function setShareUsage($shareUsage)
    {
        $this->shareUsage = $shareUsage;
    }

    /**
     * Create an instance using the response headers from the API call.
     *
     * @param array $parsed The array contains parsed response body
     *
     * @internal
     *
     * @return GetShareStatsResult
     */
    public static function create(array $parsed)
    {
        $result = new GetShareStatsResult();

        $result->setShareUsage((int) (Utilities::tryGetValueInsensitive(
            Resources::XTAG_SHARE_USAGE,
            $parsed
        )));

        return $result;
    }
}
