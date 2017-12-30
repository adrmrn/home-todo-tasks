<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 28.12.17
 * Time: 14:12
 */

namespace Shared\Infrastructure\Doctrine\Type;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;
use Shared\Application\ValueObject\Email;

class EmailType extends TextType
{
    const NAME = 'email';

    /**
     * @param mixed                                     $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return \Shared\Application\ValueObject\Email
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);

        if (TRUE === empty($value)) {
            return NULL;
        }

        return new Email($value);
    }

    /**
     * @param mixed                                     $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var Email $value */
        return parent::convertToDatabaseValue($value->toString(), $platform);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}