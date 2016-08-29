<?php

namespace Repertoire\Domain;

use Repertoire\Domain\Value\Identifier\SongId;
use Repertoire\Domain\Value\SongName;

class Song
{
    /**
     * @var SongId
     */
    private $id;

    /**
     * @var SongName
     */
    private $name;

    /**
     * @var bool If a song is or not essential.
     */
    private $essential = false;

    /**
     * Song constructor.
     * @param SongId $id The id.
     * @param SongName $name The name of the song.
     */
    public function __construct(SongId $id = null, SongName $name = null)
    {
        if (!$id || !$name) {
            throw new \InvalidArgumentException("A Song must have at least Name and Id.");
        }

        $this->id = $id;
        $this->name = $name;
    }

    public static function withName(string $name)
    {
        return new self(SongId::generate(), new SongName($name));
    }

    /**
     * @return bool Return is the song is essential.
     */
    public function isEssential()
    {
        return $this->essential;
    }

    /**
     * @return SongName
     */
    public function getName(): SongName
    {
        return $this->name;
    }

    public function isEqual(Song $song)
    {
        return $song->getName()->isEqual($this->getName());
    }
}
