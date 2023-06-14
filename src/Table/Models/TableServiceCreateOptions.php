<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Table\Internal\AcceptOptionTrait;

class TableServiceCreateOptions extends TableServiceOptions
{
    use AcceptOptionTrait;

    private $doesReturnContent;

    public function __construct()
    {
        parent::__construct();
        $this->doesReturnContent = false;
    }

    /**
     * Sets does return content.
     *
     * @param bool $doesReturnContent if the reponse returns content.
     */
    public function setDoesReturnContent($doesReturnContent)
    {
        Validate::isBoolean($doesReturnContent);
        $this->doesReturnContent = $doesReturnContent;
    }

    /**
     * Gets does return content.
     *
     * @return bool
     */
    public function getDoesReturnContent()
    {
        return $this->doesReturnContent;
    }
}
