<?php

namespace AzureOSS\Storage\Common;

class LocationMode
{
    //Request will only be sent to primary endpoint, except for
    //getServiceStats APIs.
    public const PRIMARY_ONLY = 'PrimaryOnly';

    //Request will only be sent to secondary endpoint.
    public const SECONDARY_ONLY = 'SecondaryOnly';

    //Request will be sent to primary endpoint first, and retry for secondary
    //endpoint.
    public const PRIMARY_THEN_SECONDARY = 'PrimaryThenSecondary';

    //Request will be sent to secondary endpoint first, and retry for primary
    //endpoint.
    public const SECONDARY_THEN_PRIMARY = 'SecondaryThenPrimary';
}
