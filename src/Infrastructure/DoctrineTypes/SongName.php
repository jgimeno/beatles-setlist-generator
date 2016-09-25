<?php

namespace Repertoire\Infrastructure\DoctrineTypes;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class SongName extends Type
{
    const MYTYPE = 'songname'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "VARCHAR(255)";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new \Repertoire\Domain\Value\SongName($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function getName()
    {
        return self::MYTYPE; // modify to match your constant name
    }
}
