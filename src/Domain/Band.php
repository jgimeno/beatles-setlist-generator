<?php

declare(strict_types=1);

namespace Repertoire\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Repertoire\Domain\Exception\BandAlreadyKnowsSongException;
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
    private $songsWeKnow;

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

        $this->songsWeKnow = new ArrayCollection();
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

    public function knowsSong(Song $song)
    {
        $isKnown = false;

        foreach ($this->songsWeKnow as $knownSong) {
            if ($song->isEqual($knownSong)) {
                $isKnown = true;
            }
        }

        return $isKnown;
    }

    public function addSongWeKnow(Song $song)
    {
        if ($this->knowsSong($song)) {
            throw new BandAlreadyKnowsSongException("Band already knows song ");
        }

        $this->songsWeKnow[] = $song;
        $song->assignToBand($this);
    }

    public function getSongsWeKnow(): ArrayCollection
    {
        return $this->songsWeKnow;
    }

    /**
     * Gets the band name.
     * @return BandName
     */
    public function getName(): BandName
    {
        return $this->name;
    }
}
