<?php

namespace AzureOSS\Storage\Common\Models;

use AzureOSS\Storage\Common\Internal\Resources;

class SignedIdentifier
{
    private $id;
    private $accessPolicy;

    /**
     * Constructor
     *
     * @param string            $id           The id of this signed identifier.
     * @param AccessPolicy|null $accessPolicy The access policy.
     */
    public function __construct($id = '', AccessPolicy $accessPolicy = null)
    {
        $this->setId($id);
        $this->setAccessPolicy($accessPolicy);
    }

    /**
     * Gets id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param string $id value.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Gets accessPolicy.
     *
     * @return AccessPolicy
     */
    public function getAccessPolicy()
    {
        return $this->accessPolicy;
    }

    /**
     * Sets accessPolicy.
     *
     * @param AccessPolicy|null $accessPolicy value.
     */
    public function setAccessPolicy(AccessPolicy $accessPolicy = null)
    {
        $this->accessPolicy = $accessPolicy;
    }

    /**
     * Converts this current object to XML representation.
     *
     * @internal
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        $accessPolicyArray = [];
        $accessPolicyArray[Resources::XTAG_SIGNED_ID] = $this->getId();
        $accessPolicyArray[Resources::XTAG_ACCESS_POLICY] =
            $this->getAccessPolicy()->toArray();
        $array[Resources::XTAG_SIGNED_IDENTIFIER] = $accessPolicyArray;

        return $array;
    }
}
