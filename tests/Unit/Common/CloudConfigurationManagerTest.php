<?php

namespace AzureOSS\Storage\Tests\Unit\Common;

use AzureOSS\Storage\Common\CloudConfigurationManager;
use AzureOSS\Storage\Common\Internal\ConnectionStringSource;

class CloudConfigurationManagerTest extends \PHPUnit\Framework\TestCase
{
    private $_key = 'my_connection_string';
    private $_value = 'connection string value';

    protected function setUp(): void
    {
        $isInitialized = new \ReflectionProperty('AzureOSS\Storage\Common\CloudConfigurationManager', '_isInitialized');
        $isInitialized->setAccessible(true);
        $isInitialized->setValue(false);

        $sources = new \ReflectionProperty('AzureOSS\Storage\Common\CloudConfigurationManager', '_sources');
        $sources->setAccessible(true);
        $sources->setValue([]);
    }

    public function testGetConnectionStringFromEnvironmentVariable()
    {
        // Setup
        putenv("$this->_key=$this->_value");

        // Test
        $actual = CloudConfigurationManager::getConnectionString($this->_key);

        // Assert
        self::assertEquals($this->_value, $actual);

        // Clean
        putenv($this->_key);
    }

    public function testGetConnectionStringDoesNotExist()
    {
        // Test
        $actual = CloudConfigurationManager::getConnectionString('does not exist');

        // Assert
        self::assertEmpty($actual);
    }

    public function testRegisterSource()
    {
        // Setup
        $expectedKey = $this->_key;
        $expectedValue = $this->_value . 'extravalue';

        // Test
        CloudConfigurationManager::registerSource(
            'my_source',
            static function ($key) use ($expectedKey, $expectedValue) {
                if ($key == $expectedKey) {
                    return $expectedValue;
                }
            },
        );

        // Assert
        $actual = CloudConfigurationManager::getConnectionString($expectedKey);
        self::assertEquals($expectedValue, $actual);
    }

    public function testRegisterSourceWithPrepend()
    {
        // Setup
        $expectedKey = $this->_key;
        $expectedValue = $this->_value . 'extravalue2';
        putenv("$this->_key=wrongvalue");

        // Test
        CloudConfigurationManager::registerSource(
            'my_source',
            static function ($key) use ($expectedKey, $expectedValue) {
                if ($key == $expectedKey) {
                    return $expectedValue;
                }
            },
            true,
        );

        // Assert
        $actual = CloudConfigurationManager::getConnectionString($expectedKey);
        self::assertEquals($expectedValue, $actual);

        // Clean
        putenv($this->_key);
    }

    public function testUnRegisterSource()
    {
        // Setup
        $expectedKey = $this->_key;
        $expectedValue = $this->_value . 'extravalue3';
        $name = 'my_source';
        CloudConfigurationManager::registerSource(
            $name,
            static function ($key) use ($expectedKey, $expectedValue) {
                if ($key == $expectedKey) {
                    return $expectedValue;
                }
            },
        );

        // Test
        $callback = CloudConfigurationManager::unregisterSource($name);

        // Assert
        $actual = CloudConfigurationManager::getConnectionString($expectedKey);
        self::assertEmpty($actual);
        self::assertNotNull($callback);
    }

    public function testRegisterSourceWithDefaultSource()
    {
        // Setup
        $expectedKey = $this->_key;
        $expectedValue = $this->_value . 'extravalue5';
        CloudConfigurationManager::unregisterSource(ConnectionStringSource::ENVIRONMENT_SOURCE);
        putenv("$expectedKey=$expectedValue");

        // Test
        CloudConfigurationManager::registerSource(ConnectionStringSource::ENVIRONMENT_SOURCE);

        // Assert
        $actual = CloudConfigurationManager::getConnectionString($expectedKey);
        self::assertEquals($expectedValue, $actual);

        // Clean
        putenv($expectedKey);
    }

    public function testUnRegisterSourceWithDefaultSource()
    {
        // Setup
        $expectedKey = $this->_key;
        $expectedValue = $this->_value . 'extravalue4';
        $name = 'my_source';
        CloudConfigurationManager::registerSource(
            $name,
            static function ($key) use ($expectedKey, $expectedValue) {
                if ($key == $expectedKey) {
                    return $expectedValue;
                }
            },
        );

        // Test
        $callback = CloudConfigurationManager::unregisterSource(ConnectionStringSource::ENVIRONMENT_SOURCE);

        // Assert
        $actual = CloudConfigurationManager::getConnectionString($expectedKey);
        self::assertEquals($expectedValue, $actual);
        self::assertNotNull($callback);
    }
}
