<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Internal\Validate;

class ListBlobBlocksOptions extends BlobServiceOptions
{
    private $_snapshot;
    private $_includeUncommittedBlobs;
    private $_includeCommittedBlobs;
    private static $_listType;

    /**
     * Constructs the static variable $listType.
     */
    public function __construct()
    {
        parent::__construct();
        self::$_listType[true][true] = 'all';
        self::$_listType[true][false] = 'uncommitted';
        self::$_listType[false][true] = 'committed';
        self::$_listType[false][false] = 'all';

        $this->_includeUncommittedBlobs = false;
        $this->_includeCommittedBlobs = false;
    }

    /**
     * Gets blob snapshot.
     *
     * @return string
     */
    public function getSnapshot()
    {
        return $this->_snapshot;
    }

    /**
     * Sets blob snapshot.
     *
     * @param string $snapshot value.
     */
    public function setSnapshot($snapshot)
    {
        $this->_snapshot = $snapshot;
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
     * Indicates if uncommittedBlobs is included or not.
     *
     * @return bool
     */
    public function getIncludeUncommittedBlobs()
    {
        return $this->_includeUncommittedBlobs;
    }

    /**
     * Sets the include committedBlobs flag.
     *
     * @param bool $includeCommittedBlobs value.
     */
    public function setIncludeCommittedBlobs($includeCommittedBlobs)
    {
        Validate::isBoolean($includeCommittedBlobs);
        $this->_includeCommittedBlobs = $includeCommittedBlobs;
    }

    /**
     * Indicates if committedBlobs is included or not.
     *
     * @return bool
     */
    public function getIncludeCommittedBlobs()
    {
        return $this->_includeCommittedBlobs;
    }

    /**
     * Gets block list type.
     *
     * @return string
     */
    public function getBlockListType()
    {
        $includeUncommitted = $this->_includeUncommittedBlobs;
        $includeCommitted = $this->_includeCommittedBlobs;

        return self::$_listType[$includeUncommitted][$includeCommitted];
    }
}
