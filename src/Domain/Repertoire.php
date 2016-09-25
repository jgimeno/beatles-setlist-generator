<?php

declare(strict_types=1);

namespace Repertoire\Domain;

use Repertoire\Domain\Value\Identifier\RepertoireId;
use Repertoire\Domain\Value\RepertoireName;

class Repertoire
{
    /**
     * @var RepertoireId
     */
    private $id;

    /**
     * @var RepertoireName
     */
    private $name;

    /**
     * @var Band
     */
    protected $band;

    /**
     * @var
     */
    protected $parts = [];

    public function __construct(RepertoireId $id = null, RepertoireName $name = null)
    {
        if (!$id ||!$name) {
            throw new \InvalidArgumentException("A Repertoire must have at least id and name");
        }

        $this->id = $id;
        $this->name = $name;
    }

    public static function withName($string) : Repertoire
    {
        return new self(RepertoireId::generate(), new RepertoireName($string));
    }

    public function addPart(RepertoirePart $part)
    {
        $this->parts[] = $part;
    }

    public function getParts() : array
    {
        return $this->parts;
    }

    public function assignToBand(Band $band)
    {
        $this->band = $band;
    }
}
