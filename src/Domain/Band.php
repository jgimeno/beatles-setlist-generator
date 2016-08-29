<?php

declare(strict_types=1);

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

    /**
     * @var array
     */
    private $songsWeKnow = array();

    /**
     * @var array
     */
    protected $repertoires = array();

    public function __construct(BandId $id = null, BandName $name = null)
    {
        if (!$id || !$name) {
            throw new \InvalidArgumentException("Band needs at least Id and Name");
        }

        $this->id = $id;
        $this->name = $name;
    }

    public static function withName(string $name)
    {
        return new self(BandId::generate(), new BandName($name));
    }

    public function addRepertoire(Repertoire $repertoire)
    {
        $this->repertoires[] = $repertoire;
    }

    public function getRepertoires() : array
    {
        return $this->repertoires;
    }

    public function addSongWeKnow(Song $song)
    {
        $this->songsWeKnow[] = $song;
    }

    public function getSongsWeKnow(): array
    {
        return $this->songsWeKnow;
    }
}
