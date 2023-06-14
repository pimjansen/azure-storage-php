<?php

namespace AzureOSS\Storage\Queue\Internal;

use AzureOSS\Storage\Common\Internal\Resources;

class QueueResources extends Resources
{
    // @codingStandardsIgnoreStart

    public const QUEUE_SDK_VERSION = '1.3.4';
    public const STORAGE_API_LATEST_VERSION = '2017-11-09';

    // Error messages
    public const INVALID_RECEIVE_MODE_MSG = 'The receive message option is in neither RECEIVE_AND_DELETE nor PEEK_LOCK mode.';

    // Headers
    public const X_MS_APPROXIMATE_MESSAGES_COUNT = 'x-ms-approximate-messages-count';
    public const X_MS_POPRECEIPT = 'x-ms-popreceipt';
    public const X_MS_TIME_NEXT_VISIBLE = 'x-ms-time-next-visible';

    // Query parameter names
    public const QP_VISIBILITY_TIMEOUT = 'visibilitytimeout';
    public const QP_POPRECEIPT = 'popreceipt';
    public const QP_NUM_OF_MESSAGES = 'numofmessages';
    public const QP_PEEK_ONLY = 'peekonly';
    public const QP_MESSAGE_TTL = 'messagettl';
    public const QP_QUEUE_MESSAGE = 'QueueMessage';

    // Resource permissions
    public const ACCESS_PERMISSIONS = [
        Resources::RESOURCE_TYPE_QUEUE => ['r', 'a', 'u', 'p'],
    ];

    // @codingStandardsIgnoreEnd
}
