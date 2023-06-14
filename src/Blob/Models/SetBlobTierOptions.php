<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Models\ServiceOptions;

class SetBlobTierOptions extends ServiceOptions
{
    use AccessTierTrait;
}
