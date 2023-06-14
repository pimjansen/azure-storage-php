<?php

namespace AzureOSS\Storage\Common\Models;

trait TransactionalMD5Trait
{
    /**
     * @var bool
     */
    private $useTransactionalMD5;

    /**
     * Gets whether using transactional MD5 validation.
     *
     * @return bool
     */
    public function getUseTransactionalMD5()
    {
        return $this->useTransactionalMD5;
    }

    /**
     * Sets whether using transactional MD5 validation.
     *
     * @param bool $useTransactionalMD5 whether enable transactional
     *                                  MD5 validation.
     */
    public function setUseTransactionalMD5($useTransactionalMD5)
    {
        $this->useTransactionalMD5 = $useTransactionalMD5;
    }
}
