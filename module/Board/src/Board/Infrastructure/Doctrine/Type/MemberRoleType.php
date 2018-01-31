<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 31.01.18
 * Time: 19:25
 */

namespace Board\Infrastructure\Doctrine\Type;


use Board\Domain\Model\Member\Role as MemberRole;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class MemberRoleType extends Type
{
    const NAME = 'member_role';

    /**
     * @param string                                    $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return MemberRole
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);

        return MemberRole::get($value);
    }

    /**
     * @param MemberRole                                $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getValue();
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param array                                     $fieldDeclaration The field declaration.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform         The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        throw new \RuntimeException('Action not allowed', 501);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}