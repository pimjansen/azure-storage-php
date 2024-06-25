<?php

namespace AzureOSS\Storage\Common\Models;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Internal\Utilities;

class GetServiceStatsResult
{
    private $status;
    private $lastSyncTime;

    /**
     * Creates object from $parsedResponse.
     *
     * @internal
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @return \AzureOSS\Storage\Common\Models\GetServiceStatsResult
     */
    public static function create(array $parsedResponse)
    {
        $result = new GetServiceStatsResult();
        if (Utilities::arrayKeyExistsInsensitive(
            Resources::XTAG_GEO_REPLICATION,
            $parsedResponse,
        )) {
            $geoReplication = $parsedResponse[Resources::XTAG_GEO_REPLICATION];
            if (Utilities::arrayKeyExistsInsensitive(
                Resources::XTAG_STATUS,
                $geoReplication,
            )) {
                $result->setStatus($geoReplication[Resources::XTAG_STATUS]);
            }

            if (Utilities::arrayKeyExistsInsensitive(
                Resources::XTAG_LAST_SYNC_TIME,
                $geoReplication,
            )) {
                $lastSyncTime = $geoReplication[Resources::XTAG_LAST_SYNC_TIME];
                $result->setLastSyncTime(Utilities::convertToDateTime($lastSyncTime));
            }
        }

        return $result;
    }

    /**
     * Gets status of the result.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Gets the last sync time.
     *
     * @return \DateTime
     */
    public function getLastSyncTime()
    {
        return $this->lastSyncTime;
    }

    /**
     * Sets status of the result.
     */
    protected function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Sets the last sync time.
     */
    protected function setLastSyncTime(\DateTime $lastSyncTime)
    {
        $this->lastSyncTime = $lastSyncTime;
    }
}
