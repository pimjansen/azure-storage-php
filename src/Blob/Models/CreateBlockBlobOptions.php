<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Models\TransactionalMD5Trait;

class CreateBlockBlobOptions extends CreateBlobOptions
{
    use TransactionalMD5Trait;
}
