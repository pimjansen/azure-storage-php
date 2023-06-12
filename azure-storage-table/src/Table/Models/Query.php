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
 * @see      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Table\Models;

/**
 * Query to be performed on a table
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class Query
{
    private $_selectFields;
    private $_filter;
    private $_top;

    /**
     * Gets filter.
     *
     * @return Filters\Filter
     */
    public function getFilter()
    {
        return $this->_filter;
    }

    /**
     * Sets filter.
     *
     * @param Filters\Filter $filter value.
     */
    public function setFilter($filter)
    {
        $this->_filter = $filter;
    }

    /**
     * Gets top.
     *
     * @return int
     */
    public function getTop()
    {
        return $this->_top;
    }

    /**
     * Sets top.
     *
     * @param int $top value.
     */
    public function setTop($top)
    {
        $this->_top = $top;
    }

    /**
     * Adds a field to select fields.
     *
     * @param string $field The value of the field.
     */
    public function addSelectField($field)
    {
        $this->_selectFields[] = $field;
    }

    /**
     * Gets selectFields.
     *
     * @return array
     */
    public function getSelectFields()
    {
        return $this->_selectFields;
    }

    /**
     * Sets selectFields.
     *
     * @param array $selectFields value.
     */
    public function setSelectFields(array $selectFields = null)
    {
        $this->_selectFields = $selectFields;
    }
}
