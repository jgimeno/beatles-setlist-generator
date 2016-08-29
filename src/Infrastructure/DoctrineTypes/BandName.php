<?php

namespace Repertoire\Infrastructure\DoctrineTypes;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * My custom datatype.
 */
class BandName extends Type
{
    const MYTYPE = 'bandname'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        // return the SQL used to create your column type. To create a portable column type, use the $platform.
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new \Repertoire\Domain\Value\BandName($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        // This is executed when the value is written to the database. Make your conversions here, optionally using the $platform.
    }

    public function getName()
    {
        return self::MYTYPE; // modify to match your constant name
    }
}