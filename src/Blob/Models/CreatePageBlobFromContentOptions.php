<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Models\TransactionalMD5Trait;

class CreatePageBlobFromContentOptions extends CreatePageBlobOptions
{
    use TransactionalMD5Trait;
}
