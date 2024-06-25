<?php

namespace AzureOSS\Storage\Blob\Models;

class CreateBlobBlockOptions extends BlobServiceOptions
{
    private $_contentMD5;
    private $_numberOfConcurrency;

    /**
     * Gets blob contentMD5.
     *
     * @return string
     */
    public function getContentMD5()
    {
        return $this->_contentMD5;
    }

    /**
     * Sets blob contentMD5.
     *
     * @param string $contentMD5 value.
     */
    public function setContentMD5($contentMD5)
    {
        $this->_contentMD5 = $contentMD5;
    }

    /**
     * Gets number of concurrency for sending a blob.
     *
     * @return int
     */
    public function getNumberOfConcurrency()
    {
        return $this->_numberOfConcurrency;
    }

    /**
     * Sets number of concurrency for sending a blob.
     *
     * @param int $numberOfConcurrency the number of concurrent requests.
     */
    public function setNumberOfConcurrency($numberOfConcurrency)
    {
        $this->_numberOfConcurrency = $numberOfConcurrency;
    }

    /**
     * Construct a CreateBlobBlockOptions object from a createBlobOptions.
     *
     * @return CreateBlobBlockOptions
     */
    public static function create(CreateBlobOptions $createBlobOptions)
    {
        $result = new CreateBlobBlockOptions();
        $result->setTimeout($createBlobOptions->getTimeout());
        $result->setLeaseId($createBlobOptions->getLeaseId());
        $result->setNumberOfConcurrency(
            $createBlobOptions->getNumberOfConcurrency(),
        );
        return $result;
    }
}
