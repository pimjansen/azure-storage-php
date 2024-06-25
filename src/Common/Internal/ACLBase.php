<?php

namespace AzureOSS\Storage\Common\Internal;

use AzureOSS\Storage\Common\Internal\Serialization\XmlSerializer;
use AzureOSS\Storage\Common\Models\AccessPolicy;
use AzureOSS\Storage\Common\Models\SignedIdentifier;

abstract class ACLBase
{
    private $signedIdentifiers = [];
    private $resourceType = '';

    /**
     * Create an AccessPolicy object by resource type.
     *
     * @return AccessPolicy
     */
    abstract protected static function createAccessPolicy();

    /**
     * Validate if the resource type for the class.
     *
     * @param string $resourceType the resource type to be validated.
     *
     * @throws \InvalidArgumentException
     *
     * @internal
     */
    abstract protected static function validateResourceType($resourceType);

    /**
     * Converts signed identifiers to array representation for XML serialization
     *
     * @internal
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];

        foreach ($this->getSignedIdentifiers() as $value) {
            $array[] = $value->toArray();
        }

        return $array;
    }

    /**
     * Converts this signed identifiers to XML representation.
     *
     * @internal
     *
     * @return string
     */
    public function toXml(XmlSerializer $serializer)
    {
        $properties = [
            XmlSerializer::DEFAULT_TAG => Resources::XTAG_SIGNED_IDENTIFIER,
            XmlSerializer::ROOT_NAME => Resources::XTAG_SIGNED_IDENTIFIERS,
        ];

        return $serializer->serialize($this->toArray(), $properties);
    }

    /**
     * Construct the signed identifiers from a given parsed XML in array
     * representation.
     *
     * @param array|null $parsed The parsed XML into array representation.
     *
     * @internal
     */
    public function fromXmlArray(array $parsed = null)
    {
        $this->setSignedIdentifiers([]);

        // Initialize signed identifiers.
        if (
            !empty($parsed)
            && is_array($parsed[Resources::XTAG_SIGNED_IDENTIFIER])
        ) {
            $entries = $parsed[Resources::XTAG_SIGNED_IDENTIFIER];
            $temp = Utilities::getArray($entries);

            foreach ($temp as $value) {
                $accessPolicy = $value[Resources::XTAG_ACCESS_POLICY];
                $startString = urldecode(
                    $accessPolicy[Resources::XTAG_SIGNED_START],
                );
                $expiryString = urldecode(
                    $accessPolicy[Resources::XTAG_SIGNED_EXPIRY],
                );
                $start = Utilities::convertToDateTime($startString);
                $expiry = Utilities::convertToDateTime($expiryString);
                $permission = $accessPolicy[Resources::XTAG_SIGNED_PERMISSION];
                $id = $value[Resources::XTAG_SIGNED_ID];
                $this->addSignedIdentifier($id, $start, $expiry, $permission);
            }
        }
    }

    /**
     * Gets the type of resource this ACL relate to.
     *
     * @internal
     *
     * @return string
     */
    protected function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * Set the type of resource this ACL relate to.
     *
     * @internal
     */
    protected function setResourceType($resourceType)
    {
        static::validateResourceType($resourceType);
        $this->resourceType = $resourceType;
    }

    /**
     * Add a signed identifier to the ACL.
     *
     * @param string    $id          A unique id for this signed identifier.
     * @param \DateTime $start       The time at which the Shared Access
     *                               Signature becomes valid. If omitted, start
     *                               time for this call is assumed to be the
     *                               time when the service receives the
     *                               request.
     * @param \DateTime $expiry      The time at which the Shared Access
     *                               Signature becomes invalid.
     * @param string    $permissions The permissions associated with the Shared
     *                               Access Signature. The user is restricted to
     *                               operations allowed by the permissions.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/establishing-a-stored-access-policy
     */
    public function addSignedIdentifier(
        $id,
        \DateTime $start,
        \DateTime $expiry,
        $permissions,
    ) {
        Validate::canCastAsString($id, 'id');
        if ($start != null) {
            Validate::isDate($start);
        }
        Validate::isDate($expiry);
        Validate::canCastAsString($permissions, 'permissions');

        $accessPolicy = static::createAccessPolicy();
        $accessPolicy->setStart($start);
        $accessPolicy->setExpiry($expiry);
        $accessPolicy->setPermission($permissions);

        $signedIdentifier = new SignedIdentifier();
        $signedIdentifier->setId($id);
        $signedIdentifier->setAccessPolicy($accessPolicy);

        // Remove the signed identifier with the same ID.
        $this->removeSignedIdentifier($id);

        // There can be no more than 5 signed identifiers at the same time.
        Validate::isTrue(
            count($this->getSignedIdentifiers()) < 5,
            Resources::ERROR_TOO_MANY_SIGNED_IDENTIFIERS,
        );

        $this->signedIdentifiers[] = $signedIdentifier;
    }

    /**
     * Remove the signed identifier with given ID.
     *
     * @param string $id The ID of the signed identifier to be removed.
     *
     * @return bool
     */
    public function removeSignedIdentifier($id)
    {
        Validate::canCastAsString($id, 'id');
        //var_dump($this->signedIdentifiers);
        for ($i = 0; $i < count($this->signedIdentifiers); ++$i) {
            if ($this->signedIdentifiers[$i]->getId() == $id) {
                array_splice($this->signedIdentifiers, $i, 1);
                return true;
            }
        }

        return false;
    }

    /**
     * Gets signed identifiers.
     *
     * @return array
     */
    public function getSignedIdentifiers()
    {
        return $this->signedIdentifiers;
    }

    public function setSignedIdentifiers(array $signedIdentifiers)
    {
        // There can be no more than 5 signed identifiers at the same time.
        Validate::isTrue(
            count($signedIdentifiers) <= 5,
            Resources::ERROR_TOO_MANY_SIGNED_IDENTIFIERS,
        );
        $this->signedIdentifiers = $signedIdentifiers;
    }
}
