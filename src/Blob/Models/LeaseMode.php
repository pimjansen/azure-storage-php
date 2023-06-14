<?php

namespace AzureOSS\Storage\Blob\Models;

class LeaseMode
{
    public const ACQUIRE_ACTION = 'acquire';
    public const RENEW_ACTION = 'renew';
    public const RELEASE_ACTION = 'release';
    public const BREAK_ACTION = 'break';
    public const CHANGE_ACTION = 'change';
}
