<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Table\Internal\TableResources as Resources;

class UpdateEntityResult
{
    private $_etag;

    /**
     * Creates UpdateEntityResult from HTTP response headers.
     *
     * @param array $headers The HTTP response headers.
     *
     * @internal
     *
     * @return UpdateEntityResult
     */
    public static function create(array $headers)
    {
        $result = new UpdateEntityResult();
        $result->setETag(
            Utilities::tryGetValueInsensitive(Resources::ETAG, $headers)
        );

        return $result;
    }

    /**
     * Gets entity etag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->_etag;
    }

    /**
     * Sets entity etag.
     *
     * @param string $etag The entity ETag.
     */
    protected function setETag($etag)
    {
        $this->_etag = $etag;
    }
}
