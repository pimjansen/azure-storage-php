<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Models\TransactionalMD5Trait;

class CreateFileFromContentOptions extends CreateFileOptions
{
    use TransactionalMD5Trait;
}
