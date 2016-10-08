<?php

namespace Repertoire\Domain\Service;

use Repertoire\Domain\Band;
use Repertoire\Domain\Exception\BandDoesNotKnowSongsException;
use Repertoire\Domain\Repertoire;
use Repertoire\Domain\RepertoirePart;
use Repertoire\Domain\Value\RepertoireName;

class RepertoireGenerator
{
    public function generateRepertoireFor(Band $band, RepertoireName $repertoireName, $numSongs = 10, $numParts = 1)
    {
        if (!$band->knowsAnySong()) {
            throw new BandDoesNotKnowSongsException(
                sprintf(
                    "Band %s does not know any song, I can't generate a repertoire",
                    $band->getName()
                )
            );
        }

        $songsBandKnows = $band->getSongsWeKnow();

        $repertoirePart = new RepertoirePart([
            array_rand($songsBandKnows->toArray(), $numSongs)
        ]);

        $repertoire = Repertoire::withName($repertoireName);
        $repertoire->addPart($repertoirePart);

        return $repertoire;
    }
}
