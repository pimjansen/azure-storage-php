<?php

namespace AzureOSS\Storage\Common\Internal;

class ConnectionStringSource
{
    private static $_defaultSources;
    private static $_isInitialized;
    public const ENVIRONMENT_SOURCE = 'environment_source';

    /**
     * Initializes the default sources.
     */
    private static function _init()
    {
        if (!self::$_isInitialized) {
            self::$_defaultSources = [
                self::ENVIRONMENT_SOURCE => [__CLASS__, 'environmentSource'],
            ];
            self::$_isInitialized = true;
        }
    }

    /**
     * Gets a connection string value from the system environment.
     *
     * @param string $key The connection string name.
     *
     * @return string
     */
    public static function environmentSource($key)
    {
        Validate::canCastAsString($key, 'key');

        return getenv($key);
    }

    /**
     * Gets list of default sources.
     *
     * @return array
     */
    public static function getDefaultSources()
    {
        self::_init();
        return self::$_defaultSources;
    }
}
