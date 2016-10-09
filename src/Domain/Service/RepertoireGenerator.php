<?php

namespace Repertoire\Domain\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Repertoire\Domain\Band;
use Repertoire\Domain\Constant\SongEra;
use Repertoire\Domain\Exception\BandDoesNotKnowSongsException;
use Repertoire\Domain\Repertoire;
use Repertoire\Domain\RepertoirePart;
use Repertoire\Domain\Value\RepertoireName;

class RepertoireGenerator
{
    public function generateRepertoireFor(Band $band, RepertoireName $repertoireName, $numSongs = 10, $numParts = 1)
    {
        $this->checkIfBandKnowAnySong($band);

        $repertoire = Repertoire::withName($repertoireName);

        if ($numParts == 1) {
            $songsBandKnows = $band->getSongsWeKnow();
            $repertoirePart = $this->createRepertoirePart($numSongs, $songsBandKnows);
            $repertoire->addPart($repertoirePart);
        } else {
            $songsKnownFronEra1 = $band->getSongsWeKnowByEra(SongEra::FIRST_ERA);
            $songsKnownFronEra2 = $band->getSongsWeKnowByEra(SongEra::SECOND_ERA);
            $songsKnownFronEra3 = $band->getSongsWeKnowByEra(SongEra::THIRD_ERA);

            $part1 = $this->createRepertoirePart($numSongs / 2, $songsKnownFronEra1);
            $part2 = $this->createRepertoirePart($numSongs / 2, new ArrayCollection(array_merge($songsKnownFronEra2->toArray(), $songsKnownFronEra3->toArray())));
            $repertoire->addPart($part1);
            $repertoire->addPart($part2);
        }

        return $repertoire;
    }

    /**
     * Creates a Playlist Part based on num of songs and the songs a band knows.
     * @param $numSongs
     * @param $songsBandKnows
     * @return RepertoirePart
     */
    private function createRepertoirePart($numSongs, ArrayCollection $songsBandKnows):RepertoirePart
    {
        $repertoirePart = new RepertoirePart([
            array_rand($songsBandKnows->toArray(), $numSongs)
        ]);
        return $repertoirePart;
    }

    /**
     * @param Band $band
     * @throws BandDoesNotKnowSongsException
     */
    private function checkIfBandKnowAnySong(Band $band):void
    {
        if (!$band->knowsAnySong()) {
            throw new BandDoesNotKnowSongsException(
                sprintf(
                    "Band %s does not know any song, I can't generate a repertoire",
                    $band->getName()
                )
            );
        }
    }
}
