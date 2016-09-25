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
     * @var
     */
    private $band = null;

    /**
     * Song constructor.
     * @param SongId $id The id.
     * @param SongName $name The name of the song.
     * @param bool $essential
     */
    public function __construct(SongId $id = null, SongName $name = null, int $era = null, bool $essential = false)
    {
        if (!$id || !$name || !$era) {
            throw new \InvalidArgumentException("A Song must have at least Id, name and era.");
        }

        $this->id = $id;
        $this->name = $name;
        $this->essential = $essential;
    }

    public static function withNameAndEra(string $name, int $era, $essential = false)
    {
        return new self(SongId::generate(), new SongName($name), $era, $essential);
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

    public function assignToBand(Band $band)
    {
        $this->band = $band;
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}
