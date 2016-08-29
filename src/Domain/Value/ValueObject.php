<?php

namespace Repertoire\Domain\Value;

abstract class ValueObject
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isEqual(ValueObject $value)
    {
        return $this->value == $value->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
