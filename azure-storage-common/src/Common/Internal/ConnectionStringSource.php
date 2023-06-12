<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @see      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Common\Internal;

/**
 * Holder for default connection string sources used in CloudConfigurationManager.
 *
 * @ignore
 *
 * @see      https://github.com/azure/azure-storage-php
 */
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
