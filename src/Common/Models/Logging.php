<?php

namespace AzureOSS\Storage\Common\Models;

use AzureOSS\Storage\Common\Internal\Utilities;

class Logging
{
    private $_version;
    private $_delete;
    private $_read;
    private $_write;
    private $_retentionPolicy;

    /**
     * Creates object from $parsedResponse.
     *
     * @internal
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @return Logging
     */
    public static function create(array $parsedResponse)
    {
        $result = new Logging();
        $result->setVersion($parsedResponse['Version']);
        $result->setDelete(Utilities::toBoolean($parsedResponse['Delete']));
        $result->setRead(Utilities::toBoolean($parsedResponse['Read']));
        $result->setWrite(Utilities::toBoolean($parsedResponse['Write']));
        $result->setRetentionPolicy(
            RetentionPolicy::create($parsedResponse['RetentionPolicy']),
        );

        return $result;
    }

    /**
     * Gets the retention policy
     *
     * @return AzureOSS\Storage\Common\Models\RetentionPolicy
     */
    public function getRetentionPolicy()
    {
        return $this->_retentionPolicy;
    }

    /**
     * Sets retention policy
     *
     * @param RetentionPolicy $policy object to use
     */
    public function setRetentionPolicy(RetentionPolicy $policy)
    {
        $this->_retentionPolicy = $policy;
    }

    /**
     * Gets whether all write requests should be logged.
     *
     * @return bool.
     */
    public function getWrite()
    {
        return $this->_write;
    }

    /**
     * Sets whether all write requests should be logged.
     *
     * @param bool $write new value.
     */
    public function setWrite($write)
    {
        $this->_write = $write;
    }

    /**
     * Gets whether all read requests should be logged.
     *
     * @return bool
     */
    public function getRead()
    {
        return $this->_read;
    }

    /**
     * Sets whether all read requests should be logged.
     *
     * @param bool $read new value.
     */
    public function setRead($read)
    {
        $this->_read = $read;
    }

    /**
     * Gets whether all delete requests should be logged.
     */
    public function getDelete()
    {
        return $this->_delete;
    }

    /**
     * Sets whether all delete requests should be logged.
     *
     * @param bool $delete new value.
     */
    public function setDelete($delete)
    {
        $this->_delete = $delete;
    }

    /**
     * Gets the version of Storage Analytics to configure
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * Sets the version of Storage Analytics to configure
     *
     * @param string $version new value.
     */
    public function setVersion($version)
    {
        $this->_version = $version;
    }

    /**
     * Converts this object to array with XML tags
     *
     * @internal
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'Version' => $this->_version,
            'Delete' => Utilities::booleanToString($this->_delete),
            'Read' => Utilities::booleanToString($this->_read),
            'Write' => Utilities::booleanToString($this->_write),
            'RetentionPolicy' => !empty($this->_retentionPolicy)
                ? $this->_retentionPolicy->toArray()
                : null,
        ];
    }
}
