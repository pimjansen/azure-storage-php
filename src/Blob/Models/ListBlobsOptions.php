<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Common\MarkerContinuationTokenTrait;

class ListBlobsOptions extends BlobServiceOptions
{
    use MarkerContinuationTokenTrait;

    private $_prefix;
    private $_delimiter;
    private $_maxResults;
    private $_includeMetadata;
    private $_includeSnapshots;
    private $_includeUncommittedBlobs;
    private $_includeCopy;
    private $_includeDeleted;

    /**
     * Gets prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->_prefix;
    }

    /**
     * Sets prefix.
     *
     * @param string $prefix value.
     */
    public function setPrefix($prefix)
    {
        Validate::canCastAsString($prefix, 'prefix');
        $this->_prefix = $prefix;
    }

    /**
     * Gets delimiter.
     *
     * @return string
     */
    public function getDelimiter()
    {
        return $this->_delimiter;
    }

    /**
     * Sets prefix.
     *
     * @param string $delimiter value.
     */
    public function setDelimiter($delimiter)
    {
        Validate::canCastAsString($delimiter, 'delimiter');
        $this->_delimiter = $delimiter;
    }

    /**
     * Gets max results.
     *
     * @return int
     */
    public function getMaxResults()
    {
        return $this->_maxResults;
    }

    /**
     * Sets max results.
     *
     * @param int $maxResults value.
     */
    public function setMaxResults($maxResults)
    {
        Validate::isInteger($maxResults, 'maxResults');
        $this->_maxResults = $maxResults;
    }

    /**
     * Indicates if metadata is included or not.
     *
     * @return bool
     */
    public function getIncludeMetadata()
    {
        return $this->_includeMetadata;
    }

    /**
     * Sets the include metadata flag.
     *
     * @param bool $includeMetadata value.
     */
    public function setIncludeMetadata($includeMetadata)
    {
        Validate::isBoolean($includeMetadata);
        $this->_includeMetadata = $includeMetadata;
    }

    /**
     * Indicates if snapshots is included or not.
     *
     * @return bool
     */
    public function getIncludeSnapshots()
    {
        return $this->_includeSnapshots;
    }

    /**
     * Sets the include snapshots flag.
     *
     * @param bool $includeSnapshots value.
     */
    public function setIncludeSnapshots($includeSnapshots)
    {
        Validate::isBoolean($includeSnapshots);
        $this->_includeSnapshots = $includeSnapshots;
    }

    /**
     * Indicates if uncommittedBlobs is included or not.
     *
     * @return bool
     */
    public function getIncludeUncommittedBlobs()
    {
        return $this->_includeUncommittedBlobs;
    }

    /**
     * Sets the include uncommittedBlobs flag.
     *
     * @param bool $includeUncommittedBlobs value.
     */
    public function setIncludeUncommittedBlobs($includeUncommittedBlobs)
    {
        Validate::isBoolean($includeUncommittedBlobs);
        $this->_includeUncommittedBlobs = $includeUncommittedBlobs;
    }

    /**
     * Indicates if copy is included or not.
     *
     * @return bool
     */
    public function getIncludeCopy()
    {
        return $this->_includeCopy;
    }

    /**
     * Sets the include copy flag.
     *
     * @param bool $includeCopy value.
     */
    public function setIncludeCopy($includeCopy)
    {
        Validate::isBoolean($includeCopy);
        $this->_includeCopy = $includeCopy;
    }

    /**
     * Indicates if deleted is included or not.
     *
     * @return bool
     */
    public function getIncludeDeleted()
    {
        return $this->_includeDeleted;
    }

    /**
     * Sets the include deleted flag.
     *
     * @param bool $includeDeleted value.
     */
    public function setIncludeDeleted($includeDeleted)
    {
        Validate::isBoolean($includeDeleted);
        $this->_includeDeleted = $includeDeleted;
    }
}
