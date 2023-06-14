<?php

namespace AzureOSS\Storage\Blob\Internal;

use AzureOSS\Storage\Common\Internal\Resources;

class BlobResources extends Resources
{
    public const BLOB_SDK_VERSION = '1.5.4';
    public const STORAGE_API_LATEST_VERSION = '2017-11-09';

    // Error messages
    public const INVALID_BTE_MSG = 'The blob block type must exist in %s';
    public const INVALID_BLOB_PAT_MSG = 'The provided access type is invalid.';
    public const INVALID_ACH_MSG = 'The provided access condition header is invalid';
    public const ERROR_TOO_LARGE_FOR_BLOCK_BLOB = 'Error: Exceeds the upper limit of the blob.';
    public const ERROR_RANGE_NOT_ALIGN_TO_512 = 'Error: Range of the page blob must be align to 512';
    public const ERROR_CONTAINER_NOT_EXIST = 'The specified container does not exist';
    public const ERROR_BLOB_NOT_EXIST = 'The specified blob does not exist';
    public const CONTENT_SIZE_TOO_LARGE = 'The content is too large for the selected blob type.';

    // Headers
    public const X_MS_BLOB_PUBLIC_ACCESS = 'x-ms-blob-public-access';
    public const X_MS_BLOB_SEQUENCE_NUMBER = 'x-ms-blob-sequence-number';
    public const X_MS_BLOB_SEQUENCE_NUMBER_ACTION = 'x-ms-sequence-number-action';
    public const X_MS_BLOB_TYPE = 'x-ms-blob-type';
    public const X_MS_BLOB_CONTENT_TYPE = 'x-ms-blob-content-type';
    public const X_MS_BLOB_CONTENT_ENCODING = 'x-ms-blob-content-encoding';
    public const X_MS_BLOB_CONTENT_LANGUAGE = 'x-ms-blob-content-language';
    public const X_MS_BLOB_CONTENT_MD5 = 'x-ms-blob-content-md5';
    public const X_MS_BLOB_CACHE_CONTROL = 'x-ms-blob-cache-control';
    public const X_MS_BLOB_CONTENT_DISPOSITION = 'x-ms-blob-content-disposition';
    public const X_MS_BLOB_CONTENT_LENGTH = 'x-ms-blob-content-length';
    public const X_MS_BLOB_CONDITION_MAXSIZE = 'x-ms-blob-condition-maxsize';
    public const X_MS_BLOB_CONDITION_APPENDPOS = 'x-ms-blob-condition-appendpos';
    public const X_MS_BLOB_APPEND_OFFSET = 'x-ms-blob-append-offset';
    public const X_MS_BLOB_COMMITTED_BLOCK_COUNT = 'x-ms-blob-committed-block-count';
    public const X_MS_LEASE_DURATION = 'x-ms-lease-duration';
    public const X_MS_LEASE_ID = 'x-ms-lease-id';
    public const X_MS_LEASE_TIME = 'x-ms-lease-time';
    public const X_MS_LEASE_STATUS = 'x-ms-lease-status';
    public const X_MS_LEASE_STATE = 'x-ms-lease-state';
    public const X_MS_LEASE_ACTION = 'x-ms-lease-action';
    public const X_MS_PROPOSED_LEASE_ID = 'x-ms-proposed-lease-id';
    public const X_MS_LEASE_BREAK_PERIOD = 'x-ms-lease-break-period';
    public const X_MS_PAGE_WRITE = 'x-ms-page-write';
    public const X_MS_REQUEST_SERVER_ENCRYPTED = 'x-ms-request-server-encrypted';
    public const X_MS_SERVER_ENCRYPTED = 'x-ms-server-encrypted';
    public const X_MS_INCREMENTAL_COPY = 'x-ms-incremental-copy';
    public const X_MS_COPY_DESTINATION_SNAPSHOT = 'x-ms-copy-destination-snapshot';
    public const X_MS_ACCESS_TIER = 'x-ms-access-tier';
    public const X_MS_ACCESS_TIER_INFERRED = 'x-ms-access-tier-inferred';
    public const X_MS_ACCESS_TIER_CHANGE_TIME = 'x-ms-access-tier-change-time';
    public const X_MS_ARCHIVE_STATUS = 'x-ms-archive-status';
    public const MAX_BLOB_SIZE = 'x-ms-blob-condition-maxsize';
    public const MAX_APPEND_POSITION = 'x-ms-blob-condition-appendpos';
    public const SEQUENCE_NUMBER_LESS_THAN_OR_EQUAL = 'x-ms-if-sequence-number-le';
    public const SEQUENCE_NUMBER_LESS_THAN = 'x-ms-if-sequence-number-lt';
    public const SEQUENCE_NUMBER_EQUAL = 'x-ms-if-sequence-number-eq';
    public const BLOB_CONTENT_MD5 = 'x-ms-blob-content-md5';

    // Query parameters
    public const QP_DELIMITER = 'Delimiter';
    public const QP_BLOCKID = 'blockid';
    public const QP_BLOCK_LIST_TYPE = 'blocklisttype';
    public const QP_PRE_SNAPSHOT = 'prevsnapshot';

    // Resource permissions
    public const ACCESS_PERMISSIONS = [
        Resources::RESOURCE_TYPE_BLOB => ['r', 'a', 'c', 'w', 'd'],
        Resources::RESOURCE_TYPE_CONTAINER => ['r', 'a', 'c', 'w', 'd', 'l'],
    ];
}
