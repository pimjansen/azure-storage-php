<?php

namespace AzureOSS\Storage\Common\Models;

use AzureOSS\Storage\Common\Internal\Utilities;

class RetentionPolicy
{
    private $_enabled;
    private $_days;

    /**
     * Creates object from $parsedResponse.
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @internal
     *
     * @return AzureOSS\Storage\Common\Models\RetentionPolicy
     */
    public static function create(array $parsedResponse = null)
    {
        $result = new RetentionPolicy();
        $result->setEnabled(Utilities::toBoolean($parsedResponse['Enabled']));
        if ($result->getEnabled()) {
            $result->setDays((int) ($parsedResponse['Days']));
        }

        return $result;
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
     * Gets days field.
     *
     * @return int
     */
    public function getDays()
    {
        return $this->_days;
    }

    /**
     * Sets days field.
     *
     * @param int $days value to use.
     */
    public function setDays($days)
    {
        $this->_days = $days;
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
        $array = ['Enabled' => Utilities::booleanToString($this->_enabled)];
        if (isset($this->_days)) {
            $array['Days'] = (string) ($this->_days);
        }

        return $array;
    }
}
