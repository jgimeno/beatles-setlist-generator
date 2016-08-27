<?php

namespace Repertoire\Domain\Value\Identifier;

use Ramsey\Uuid\Uuid;
use Repertoire\Domain\Value\ValueObject;

class Identifier extends ValueObject
{
    public static function generate()
    {
        return new static(Uuid::uuid4());
    }
}