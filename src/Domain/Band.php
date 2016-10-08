<?php

declare(strict_types=1);

namespace Repertoire\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Repertoire\Domain\Constant\SongEra;
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
     * @var ArrayCollection
     */
    private $songsWeKnow;

    /**
     * @var ArrayCollection
     */
    protected $repertoires;

    protected function __construct(BandId $id = null, BandName $name = null)
    {
        if (!$id || !$name) {
            throw new \InvalidArgumentException("Band needs at least Id and Name");
        }

        $this->id = $id;
        $this->name = $name;

        $this->songsWeKnow = new ArrayCollection();
        $this->repertoires = new ArrayCollection();
    }

    public static function withName(string $name)
    {
        return new self(BandId::generate(), new BandName($name));
    }

    public function addRepertoire(Repertoire $repertoire)
    {
        $this->repertoires[] = $repertoire;
        $repertoire->assignToBand($this);
    }

    public function getRepertoires() : ArrayCollection
    {
        return $this->repertoires;
    }

    /**
     * Checks if the band knows the given Song.
     * @param Song $song
     * @return bool
     */
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

    public function getSongsWeKnowByEra(int $songEra, bool $essential = false): ArrayCollection
    {
        return $this->songsWeKnow->filter(
            function ($song) use ($songEra, $essential) {
                if ($essential) {
                    return $song->isFromEra($songEra) && $song->isEssential();
                } else {
                    return $song->isFromEra($songEra);
                }
            }
        );
    }

    public function addSongWeKnow(Song $song)
    {
        if ($this->knowsSong($song)) {
            throw new BandAlreadyKnowsSongException("Band already knows song $song");
        }

        $this->songsWeKnow[] = $song;
        $song->assignToBand($this);
    }

    public function getSongsWeKnow(): ArrayCollection
    {
        return $this->songsWeKnow;
    }

    public function knowsAnySong(): bool
    {
        return !$this->songsWeKnow->isEmpty();
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
