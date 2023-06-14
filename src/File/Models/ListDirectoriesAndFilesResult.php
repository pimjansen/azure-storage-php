<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\MarkerContinuationTokenTrait;
use AzureOSS\Storage\Common\Models\MarkerContinuationToken;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class ListDirectoriesAndFilesResult
{
    use MarkerContinuationTokenTrait;

    private $directories;
    private $files;
    private $maxResults;
    private $accountName;
    private $marker;

    /**
     * Creates ListDirectoriesAndFilesResult object from parsed XML response.
     *
     * @param array  $parsedResponse XML response parsed into array.
     * @param string $location       Contains the location for the previous
     *                               request.
     *
     * @internal
     *
     * @return ListDirectoriesAndFilesResult
     */
    public static function create(array $parsedResponse, $location = '')
    {
        $result = new ListDirectoriesAndFilesResult();
        $serviceEndpoint = Utilities::tryGetKeysChainValue(
            $parsedResponse,
            Resources::XTAG_ATTRIBUTES,
            Resources::XTAG_SERVICE_ENDPOINT
        );
        $result->setAccountName(Utilities::tryParseAccountNameFromUrl(
            $serviceEndpoint
        ));

        $nextMarker = Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_NEXT_MARKER
        );

        if ($nextMarker != null) {
            $result->setContinuationToken(
                new MarkerContinuationToken(
                    $nextMarker,
                    $location
                )
            );
        }

        $result->setMaxResults(Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_MAX_RESULTS
        ));

        $result->setMarker(Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_MARKER
        ));

        $entries = Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_ENTRIES
        );

        if (empty($entries)) {
            $result->setDirectories([]);
            $result->setFiles([]);
        } else {
            $directoriesArray = Utilities::tryGetValue(
                $entries,
                Resources::QP_DIRECTORY
            );
            $filesArray = Utilities::tryGetValue(
                $entries,
                Resources::QP_FILE
            );

            $directories = [];
            $files = [];

            if ($directoriesArray != null) {
                if (array_key_exists(Resources::QP_NAME, $directoriesArray)) {
                    $directoriesArray = [$directoriesArray];
                }
                foreach ($directoriesArray as $directoryArray) {
                    $directories[] = Directory::create($directoryArray);
                }
            }

            if ($filesArray != null) {
                if (array_key_exists(Resources::QP_NAME, $filesArray)) {
                    $filesArray = [$filesArray];
                }
                foreach ($filesArray as $fileArray) {
                    $files[] = File::create($fileArray);
                }
            }

            $result->setDirectories($directories);
            $result->setFiles($files);
        }

        return $result;
    }

    /**
     * Sets Directories.
     *
     * @param array $directories list of directories.
     */
    protected function setDirectories(array $directories)
    {
        $this->directories = [];
        foreach ($directories as $directory) {
            $this->directories[] = clone $directory;
        }
    }

    /**
     * Gets directories.
     *
     * @return Directory[]
     */
    public function getDirectories()
    {
        return $this->directories;
    }

    /**
     * Sets files.
     *
     * @param array $files list of files.
     */
    protected function setFiles(array $files)
    {
        $this->files = [];
        foreach ($files as $file) {
            $this->files[] = clone $file;
        }
    }

    /**
     * Gets files.
     *
     * @return File[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Gets max results.
     *
     * @return string
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * Sets max results.
     *
     * @param string $maxResults value.
     */
    protected function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
    }

    /**
     * Gets marker.
     *
     * @return string
     */
    public function getMarker()
    {
        return $this->marker;
    }

    /**
     * Sets marker.
     *
     * @param string $marker value.
     */
    protected function setMarker($marker)
    {
        $this->marker = $marker;
    }

    /**
     * Gets account name.
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * Sets account name.
     *
     * @param string $accountName value.
     */
    protected function setAccountName($accountName)
    {
        $this->accountName = $accountName;
    }
}
