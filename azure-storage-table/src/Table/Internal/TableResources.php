<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Internal
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Table\Internal;

use MicrosoftAzure\Storage\Common\Internal\Resources;

/**
 * Project resources.
 *
 * @ignore
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Internal
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class TableResources extends Resources
{
    // @codingStandardsIgnoreStart

    public const TABLE_SDK_VERSION = '1.1.6';
    public const STORAGE_API_LATEST_VERSION = '2016-05-31';

    public const DATA_SERVICE_VERSION_VALUE = '3.0';
    public const MAX_DATA_SERVICE_VERSION_VALUE = '3.0;NetFx';
    public const ACCEPT_HEADER_VALUE = 'application/json';
    public const JSON_FULL_METADATA_CONTENT_TYPE = 'application/json;odata=fullmetadata';
    public const JSON_MINIMAL_METADATA_CONTENT_TYPE = 'application/json;odata=minimalmetadata';
    public const JSON_NO_METADATA_CONTENT_TYPE = 'application/json;odata=nometadata';
    public const ACCEPT_CHARSET_VALUE = 'utf-8';

    // Error messages
    public const INVALID_EDM_MSG = 'The provided EDM type is invalid.';
    public const INVALID_PROP_MSG = 'One of the provided properties is not an instance of class Property';
    public const INVALID_ENTITY_MSG = 'The provided entity object is invalid.';
    public const INVALID_BO_TYPE_MSG = 'Batch operation name is not supported or invalid.';
    public const INVALID_BO_PN_MSG = 'Batch operation parameter is not supported.';
    public const INVALID_OC_COUNT_MSG = 'Operations and contexts must be of same size.';
    public const NULL_TABLE_KEY_MSG = 'Partition and row keys can\'t be NULL.';
    public const BATCH_ENTITY_DEL_MSG = 'The entity was deleted successfully.';
    public const INVALID_PROP_VAL_MSG = "'%s' property value must satisfy %s.";

    // Query parameters
    public const QP_SELECT = '$select';
    public const QP_TOP = '$top';
    public const QP_SKIP = '$skip';
    public const QP_FILTER = '$filter';
    public const QP_NEXT_TABLE_NAME = 'NextTableName';
    public const QP_NEXT_PK = 'NextPartitionKey';
    public const QP_NEXT_RK = 'NextRowKey';

    // Request body content types
    public const XML_CONTENT_TYPE = 'application/xml';
    public const JSON_CONTENT_TYPE = 'application/json';

    //JSON Tags
    public const JSON_TABLE_NAME = 'TableName';
    public const JSON_VALUE = 'value';
    public const JSON_ODATA_METADATA = 'odata.metadata';
    public const JSON_ODATA_TYPE = 'odata.type';
    public const JSON_ODATA_ID = 'odata.id';
    public const JSON_ODATA_EDITLINK = 'odata.editLink';
    public const JSON_ODATA_TYPE_SUFFIX = '@odata.type';
    public const JSON_ODATA_ETAG = 'odata.etag';
    public const JSON_PARTITION_KEY = 'PartitionKey';
    public const JSON_ROW_KEY = 'RowKey';
    public const JSON_TIMESTAMP = 'Timestamp';
    public const JSON_CUSTOMER_SINCE = 'CustomerSince';

    // Resource permissions
    public const ACCESS_PERMISSIONS = [
        Resources::RESOURCE_TYPE_TABLE => ['r', 'a', 'u', 'd']
    ];

    // @codingStandardsIgnoreEnd
}
