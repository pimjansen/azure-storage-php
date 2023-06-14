<?php

namespace AzureOSS\Storage\Tests\Functional\Common;

use AzureOSS\Storage\Common\SharedAccessSignatureHelper;

class SharedAccessSignatureHelperMock extends SharedAccessSignatureHelper
{
    public function getAccountName()
    {
        return $this->accountName;
    }

    public function getAccountKey()
    {
        return $this->accountKey;
    }
}
