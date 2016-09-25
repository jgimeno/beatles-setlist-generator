<?php

namespace Repertoire\Domain\Value;

class BandName extends ValueObject
{
    public function getName(): string
    {
        return (string) $this->value;
    }
}
