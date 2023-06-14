<?php

namespace AzureOSS\Storage\Table\Internal;

interface IMimeReaderWriter
{
    /**
     * Given array of MIME parts in raw string, this function converts them into MIME
     * representation.
     *
     * @param array $bodyPartContents The MIME body parts.
     *
     * @return array Returns array with two elements 'headers' and 'body' which
     *               represents the MIME message.
     */
    public function encodeMimeMultipart(array $bodyPartContents);

    /**
     * Parses given mime HTTP response body into array. Each array element
     * represents a change set result.
     *
     * @param string $mimeBody The raw MIME body result.
     *
     * @return array
     */
    public function decodeMimeMultipart($mimeBody);
}
