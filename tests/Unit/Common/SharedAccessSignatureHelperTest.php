<?php

declare(strict_types=1);

namespace AzureOSS\Storage\Tests\Unit\Common;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\SharedAccessSignatureHelper;
use AzureOSS\Storage\Tests\Framework\ReflectionTestBase;
use AzureOSS\Storage\Tests\Framework\TestResources;

class SharedAccessSignatureHelperTest extends ReflectionTestBase
{
    public function testConstruct()
    {
        // Setup
        $accountName = TestResources::ACCOUNT_NAME;
        $accountKey = TestResources::KEY4;

        // Test
        $sasHelper = new SharedAccessSignatureHelper($accountName, $accountKey);

        // Assert
        self::assertNotNull($sasHelper);

        return $sasHelper;
    }

    public function testValidateAndSanitizeSignedService()
    {
        // Setup
        $sasHelper = $this->testConstruct();
        $validateAndSanitizeSignedService = self::getMethod('validateAndSanitizeSignedService', $sasHelper);

        $authorizedSignedService = [];
        $authorizedSignedService[] = 'BqtF';
        $authorizedSignedService[] = 'bQtF';
        $authorizedSignedService[] = 'fqTb';
        $authorizedSignedService[] = 'ffqq';
        $authorizedSignedService[] = 'BbbB';

        $expected = [];
        $expected[] = 'bqtf';
        $expected[] = 'bqtf';
        $expected[] = 'bqtf';
        $expected[] = 'qf';
        $expected[] = 'b';

        for ($i = 0; $i < count($authorizedSignedService); ++$i) {
            // Test
            $actual = $validateAndSanitizeSignedService->invokeArgs($sasHelper, [$authorizedSignedService[$i]]);

            // Assert
            self::assertEquals($expected[$i], $actual);
        }
    }

    public function testValidateAndSanitizeSignedServiceThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The string should only be a combination of');

        // Setup
        $sasHelper = $this->testConstruct();
        $validateAndSanitizeSignedService = self::getMethod('validateAndSanitizeSignedService', $sasHelper);
        $unauthorizedSignedService = 'BqTfG';

        // Test: should throw an InvalidArgumentException
        $validateAndSanitizeSignedService->invokeArgs($sasHelper, [$unauthorizedSignedService]);
    }

    public function testValidateAndSanitizeSignedResourceType()
    {
        // Setup
        $sasHelper = $this->testConstruct();
        $validateAndSanitizeSignedResourceType = self::getMethod('validateAndSanitizeSignedResourceType', $sasHelper);

        $authorizedSignedResourceType = [];
        $authorizedSignedResourceType[] = 'sCo';
        $authorizedSignedResourceType[] = 'Ocs';
        $authorizedSignedResourceType[] = 'OOsCc';
        $authorizedSignedResourceType[] = 'OOOoo';

        $expected = [];
        $expected[] = 'sco';
        $expected[] = 'sco';
        $expected[] = 'sco';
        $expected[] = 'o';

        for ($i = 0; $i < count($authorizedSignedResourceType); ++$i) {
            // Test
            $actual = $validateAndSanitizeSignedResourceType->invokeArgs(
                $sasHelper,
                [$authorizedSignedResourceType[$i]],
            );

            // Assert
            self::assertEquals($expected[$i], $actual);
        }
    }

    public function testValidateAndSanitizeSignedResourceTypeThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The string should only be a combination of');

        // Setup
        $sasHelper = $this->testConstruct();
        $validateAndSanitizeSignedResourceType = self::getMethod('validateAndSanitizeSignedResourceType', $sasHelper);

        $unauthorizedSignedResourceType = 'oscB';

        // Test: should throw an InvalidArgumentException
        $validateAndSanitizeSignedResourceType->invokeArgs($sasHelper, [$unauthorizedSignedResourceType]);
    }

    public function testValidateAndSanitizeSignedProtocol()
    {
        // Setup
        $sasHelper = $this->testConstruct();
        $validateAndSanitizeSignedProtocol = self::getMethod('validateAndSanitizeSignedProtocol', $sasHelper);

        $authorizedSignedProtocol = [];
        $authorizedSignedProtocol[] = 'hTTpS';
        $authorizedSignedProtocol[] = 'httpS,hTtp';

        $expected = [];
        $expected[] = 'https';
        $expected[] = 'https,http';

        for ($i = 0; $i < count($authorizedSignedProtocol); ++$i) {
            // Test
            $actual = $validateAndSanitizeSignedProtocol->invokeArgs($sasHelper, [$authorizedSignedProtocol[$i]]);

            // Assert
            self::assertEquals($expected[$i], $actual);
        }
    }

    public function testValidateAndSanitizeSignedProtocolThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('is invalid');

        // Setup
        $sasHelper = $this->testConstruct();
        $validateAndSanitizeSignedProtocol = self::getMethod('validateAndSanitizeSignedProtocol', $sasHelper);

        $unauthorizedSignedProtocol = 'htTp';

        // Test: should throw an InvalidArgumentException
        $validateAndSanitizeSignedProtocol->invokeArgs(
            $sasHelper,
            [$unauthorizedSignedProtocol],
        );
    }

    public function testGenerateAccountSharedAccessSignatureToken()
    {
        // Setup
        $accountName = TestResources::ACCOUNT_NAME;
        $accountKey = TestResources::KEY4;

        // Test
        $sasHelper = new SharedAccessSignatureHelper($accountName, $accountKey);

        // create the test cases
        $testCases = TestResources::getSASInterestingUTCases();

        foreach ($testCases as $testCase) {
            // test
            $actualSignature = $sasHelper->generateAccountSharedAccessSignatureToken(
                $testCase[0],
                $testCase[1],
                $testCase[2],
                $testCase[3],
                $testCase[4],
                $testCase[5],
                $testCase[6],
                $testCase[7],
            );

            // assert
            self::assertEquals($testCase[8], urlencode($actualSignature));
        }
    }

    public function testValidateAndSanitizeSignedPermissions()
    {
        // Setup
        $sasHelper = $this->testConstruct();
        $validateAndSanitizeSignedPermissions = self::getMethod(
            'validateAndSanitizeSignedPermissions',
            $sasHelper,
        );

        $pairs = TestResources::getInterestingSignedResourcePermissionsPair();

        $expectedErrorMessage = \substr(
            Resources::STRING_NOT_WITH_GIVEN_COMBINATION,
            0,
            strpos(Resources::STRING_NOT_WITH_GIVEN_COMBINATION, '%s'),
        );

        foreach ($pairs as $pair) {
            if ($pair['expected'] == '') {
                $message = '';
                try {
                    $validateAndSanitizeSignedPermissions->invokeArgs(
                        $sasHelper,
                        [$pair['sp'], $pair['sr']],
                    );
                } catch (\InvalidArgumentException $e) {
                    $message = $e->getMessage();
                }
                self::assertStringContainsString(
                    $expectedErrorMessage,
                    $message,
                );
            } else {
                $result = $validateAndSanitizeSignedPermissions->invokeArgs(
                    $sasHelper,
                    [$pair['sp'], $pair['sr']],
                );
                self::assertEquals($pair['expected'], $result);
            }
        }
    }

    public function testGenerateCanonicalResource()
    {
        // Setup
        $sasHelper = $this->testConstruct();
        $validateAndSanitizeSignedService = self::getMethod('generateCanonicalResource', $sasHelper);

        $resourceNames = [];
        $resourceNames[] = 'filename';
        $resourceNames[] = '/filename';
        $resourceNames[] = '/filename/';
        $resourceNames[] = 'folder/filename';
        $resourceNames[] = '/folder/filename';
        $resourceNames[] = '/folder/filename/';
        $resourceNames[] = '/folder/eñe20!.pdf/';

        $expected = [];
        $expected[] = '/blob/test/filename';
        $expected[] = '/blob/test/filename';
        $expected[] = '/blob/test/filename/';
        $expected[] = '/blob/test/folder/filename';
        $expected[] = '/blob/test/folder/filename';
        $expected[] = '/blob/test/folder/filename/';
        $expected[] = '/blob/test/folder/eñe20!.pdf/';

        for ($i = 0; $i < count($resourceNames); ++$i) {
            // Test
            $actual = $validateAndSanitizeSignedService->invokeArgs(
                $sasHelper,
                ['test', Resources::RESOURCE_TYPE_BLOB, $resourceNames[$i]],
            );

            // Assert
            self::assertEquals($expected[$i], $actual);
        }
    }
}
