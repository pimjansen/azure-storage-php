<?php

namespace AzureOSS\Storage\Common;

use AzureOSS\Storage\Common\Internal\ConnectionStringSource;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Internal\Validate;

class CloudConfigurationManager
{
    private static $_isInitialized = false;
    private static $_sources;

    /**
     * Restrict users from creating instances from this class
     */
    private function __construct() {}

    /**
     * Initializes the connection string source providers.
     */
    private static function _init()
    {
        if (!self::$_isInitialized) {
            self::$_sources = [];

            // Get list of default connection string sources.
            $default = ConnectionStringSource::getDefaultSources();
            foreach ($default as $name => $provider) {
                self::$_sources[$name] = $provider;
            }

            self::$_isInitialized = true;
        }
    }

    /**
     * Gets a connection string from all available sources.
     *
     * @param string $key The connection string key name.
     *
     * @return string If the key does not exist return null.
     */
    public static function getConnectionString($key)
    {
        Validate::canCastAsString($key, 'key');

        self::_init();
        $value = null;

        foreach (self::$_sources as $source) {
            $value = call_user_func_array($source, [$key]);

            if (!empty($value)) {
                break;
            }
        }

        return $value;
    }

    /**
     * Registers a new connection string source provider. If the source to get
     * registered is a default source, only the name of the source is required.
     *
     * @param string   $name     The source name.
     * @param callable $provider The source callback.
     * @param bool     $prepend  When true, the $provider is processed first when
     *                           calling getConnectionString. When false (the default) the $provider is
     *                           processed after the existing callbacks.
     */
    public static function registerSource($name, $provider = null, $prepend = false)
    {
        Validate::canCastAsString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');

        self::_init();
        $default = ConnectionStringSource::getDefaultSources();

        // Try to get callback if the user is trying to register a default source.
        $provider = Utilities::tryGetValue($default, $name, $provider);

        Validate::notNullOrEmpty($provider, 'callback');

        if ($prepend) {
            self::$_sources = array_merge(
                [$name => $provider],
                self::$_sources,
            );
        } else {
            self::$_sources[$name] = $provider;
        }
    }

    /**
     * Unregisters a connection string source.
     *
     * @param string $name The source name.
     *
     * @return callable
     */
    public static function unregisterSource($name)
    {
        Validate::canCastAsString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');

        self::_init();

        $sourceCallback = Utilities::tryGetValue(self::$_sources, $name);

        if (null !== $sourceCallback) {
            unset(self::$_sources[$name]);
        }

        return $sourceCallback;
    }
}
