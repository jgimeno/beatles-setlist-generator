<?php

namespace Repertoire\Domain;

use Repertoire\Domain\Value\BandName;
use Repertoire\Domain\Value\Identifier\BandId;

class Band
{
    /**
     * @var BandId
     */
    private $id;

    /**
     * @var BandName
     */
    private $name;

    public function __construct(BandId $id = null, BandName $name = null)
    {
        if (!$id || !$name) {
            throw new \InvalidArgumentException("Band needs at least Id and Name");
        }

        $this->id = $id;
        $this->name = $name;
    }
}