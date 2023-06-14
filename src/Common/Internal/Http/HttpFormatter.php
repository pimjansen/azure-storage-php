<?php

namespace AzureOSS\Storage\Common\Internal\Http;

class HttpFormatter
{
    /**
     * Convert a http headers array into an uniformed format for further process
     *
     * @param array $headers headers for format
     *
     * @return array
     */
    public static function formatHeaders(array $headers)
    {
        $result = [];
        foreach ($headers as $key => $value) {
            if (is_array($value) && count($value) == 1) {
                $result[strtolower($key)] = $value[0];
            } else {
                $result[strtolower($key)] = $value;
            }
        }

        return $result;
    }
}
