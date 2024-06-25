<?php

namespace AzureOSS\Storage\Common\Models;

use AzureOSS\Storage\Common\Internal\Utilities;

class Metrics
{
    private $_version;
    private $_enabled;
    private $_includeAPIs;
    private $_retentionPolicy;

    /**
     * Creates object from $parsedResponse.
     *
     * @internal
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @return Metrics
     */
    public static function create(array $parsedResponse)
    {
        $result = new Metrics();
        $result->setVersion($parsedResponse['Version']);
        $result->setEnabled(Utilities::toBoolean($parsedResponse['Enabled']));
        if ($result->getEnabled()) {
            $result->setIncludeAPIs(
                Utilities::toBoolean($parsedResponse['IncludeAPIs']),
            );
        }
        $result->setRetentionPolicy(
            RetentionPolicy::create($parsedResponse['RetentionPolicy']),
        );

        return $result;
    }

    /**
     * Gets retention policy
     *
     * @return RetentionPolicy
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
     * Gets include APIs.
     *
     * @return bool
     */
    public function getIncludeAPIs()
    {
        return $this->_includeAPIs;
    }

    /**
     * Sets include APIs.
     *
     * @param bool $includeAPIs value to use.
     */
    public function setIncludeAPIs($includeAPIs)
    {
        $this->_includeAPIs = $includeAPIs;
    }

    /**
     * Gets enabled.
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->_enabled;
    }

    /**
     * Sets enabled.
     *
     * @param bool $enabled value to use.
     */
    public function setEnabled($enabled)
    {
        $this->_enabled = $enabled;
    }

    /**
     * Gets version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * Sets version
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
        $array = [
            'Version' => $this->_version,
            'Enabled' => Utilities::booleanToString($this->_enabled),
        ];
        if ($this->_enabled) {
            $array['IncludeAPIs'] = Utilities::booleanToString($this->_includeAPIs);
        }
        $array['RetentionPolicy'] = !empty($this->_retentionPolicy)
            ? $this->_retentionPolicy->toArray()
            : null;

        return $array;
    }
}
