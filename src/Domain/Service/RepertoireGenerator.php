<?php

namespace Repertoire\Domain\Service;

use Repertoire\Domain\Band;
use Repertoire\Domain\Exception\BandDoesNotKnowSongsException;
use Repertoire\Domain\Repertoire;
use Repertoire\Domain\Value\RepertoireName;

class RepertoireGenerator
{
    public function generateRepertoireFor(Band $band, RepertoireName $repertoireName)
    {
        if (!$band->knowsAnySong()) {
            throw new BandDoesNotKnowSongsException(
                sprintf(
                    "Band %s does not know any song, I can't generate a repertoire",
                    $band->getName()
                )
            );
        }

        return Repertoire::withName($repertoireName);
    }
}
