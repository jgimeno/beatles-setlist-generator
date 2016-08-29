<?php

namespace Tests\Repertoire\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Repertoire\Domain\Band;
use Repertoire\Domain\Exception\BandAlreadyKnowsSongException;
use Repertoire\Domain\Repertoire;
use Repertoire\Domain\Song;

class BandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testABandMustHaveAtLeastNameAndId()
    {
        new Band();
    }

    public function testABandCanHaveMultipleRepertoires()
    {
        $band = Band::withName("The Beatboys");

        $repertoire1 = Repertoire::withName("Castañada 2010");

        $band->addRepertoire($repertoire1);

        $this->assertEquals([$repertoire1], $band->getRepertoires());

        $repertoire2 = Repertoire::withName("Fiesta Mayor Sabadell 2012");
        $band->addRepertoire($repertoire2);

        $this->assertEquals([$repertoire1, $repertoire2], $band->getRepertoires());
    }

    public function testABandHasSongsThatTHeyKnowHowToPlay()
    {
        $band = Band::withName("The Beatboys");

        $songWeKnow = Song::withName("Hey Jude");

        $band->addSongWeKnow($songWeKnow);
        $this->assertEquals(new ArrayCollection([$songWeKnow]), $band->getSongsWeKnow());
    }

    /**
     * @expectedException Repertoire\Domain\Exception\BandAlreadyKnowsSongException
     */
    public function testWeCannotAddASongWeAlreadyKnowIntoTheBand()
    {
        $band = Band::withName("The Beatboys");

        $songWeKnow = Song::withName("Hey Jude");

        $band->addSongWeKnow($songWeKnow);

        $alreadyKnownSong = Song::withName("Hey Jude");

        $band->addSongWeKnow($alreadyKnownSong);
    }
}
