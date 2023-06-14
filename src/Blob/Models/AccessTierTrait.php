<?php

namespace AzureOSS\Storage\Blob\Models;

trait AccessTierTrait
{
    /**
     * @var string Version 2017-04-17 and newer. For page blobs on a premium storage account, otherwise a block blob
     *             on blob storage account or storageV2 general account.
     *             Specifies the tier to be set on the blob. Currently, for block blob, tiers like "Hot", "Cool"
     *             and "Archive" can be used; for premium page blobs, "P4", "P6", "P10" and etc. can be set.
     *             Check following link for a full list of supported tiers.
     *             https://docs.microsoft.com/en-us/rest/api/storageservices/set-blob-tier
     */
    private $accessTier;

    /**
     * Gets blob access tier.
     *
     * @return string
     */
    public function getAccessTier()
    {
        return $this->accessTier;
    }

    /**
     * Sets blob access tier.
     *
     * @param string $accessTier value.
     */
    public function setAccessTier($accessTier)
    {
        $this->accessTier = $accessTier;
    }
}
