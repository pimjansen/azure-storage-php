<?php

namespace AzureOSS\Storage\Table\Internal;

use AzureOSS\Storage\Table\Models\AcceptJSONContentType;

trait AcceptOptionTrait
{
    private $accept = AcceptJSONContentType::MINIMAL_METADATA;

    /**
     * Sets accept content type.
     * AcceptableJSONContentType::NO_METADATA
     * AcceptableJSONContentType::MINIMAL_METADATA
     * AcceptableJSONContentType::FULL_METADATA
     *
     * @param string $accept The accept content type to be set.
     */
    public function setAccept($accept)
    {
        AcceptJSONContentType::validateAcceptContentType($accept);
        $this->accept = $accept;
    }

    /**
     * Gets accept content type.
     *
     * @return string
     */
    public function getAccept()
    {
        return $this->accept;
    }
}
