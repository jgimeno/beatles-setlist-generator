<?php

namespace Tests\Repertoire\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Repertoire\Domain\Band;
use Repertoire\Domain\Constant\SongEra;
use Repertoire\Domain\Repertoire;
use Repertoire\Domain\Song;

class BandTest extends \PHPUnit_Framework_TestCase
{
    public function testABandCanHaveMultipleRepertoires()
    {
        $band = Band::withName("The Beatboys");

        $repertoire1 = Repertoire::withName("Castañada 2010");

        $band->addRepertoire($repertoire1);

        $this->assertEquals(new ArrayCollection([$repertoire1]), $band->getRepertoires());

        $repertoire2 = Repertoire::withName("Fiesta Mayor Sabadell 2012");
        $band->addRepertoire($repertoire2);

        $this->assertEquals(new ArrayCollection([$repertoire1, $repertoire2]), $band->getRepertoires());
    }

    public function testABandHasSongsThatTHeyKnowHowToPlay()
    {
        $band = Band::withName("The Beatboys");

        $songWeKnow = Song::withNameAndEra("Hey Jude", SongEra::THIRD_ERA);

        $band->addSongWeKnow($songWeKnow);
        $this->assertEquals(new ArrayCollection([$songWeKnow]), $band->getSongsWeKnow());
    }

    /**
     * @expectedException Repertoire\Domain\Exception\BandAlreadyKnowsSongException
     */
    public function testWeCannotAddASongWeAlreadyKnowIntoTheBand()
    {
        $band = Band::withName("The Beatboys");

        $songWeKnow = Song::withNameAndEra("Hey Jude", SongEra::THIRD_ERA);

        $band->addSongWeKnow($songWeKnow);

        $alreadyKnownSong = Song::withNameAndEra("Hey Jude", SongEra::THIRD_ERA);

        $band->addSongWeKnow($alreadyKnownSong);
    }

    public function testBandCanSayIfItKnowsOrNotAnySong()
    {
        $band = Band::withName("Abbey Road");
        $this->assertFalse($band->knowsAnySong());

        $songWeKnow = Song::withNameAndEra("Hey Jude", SongEra::THIRD_ERA);
        $band->addSongWeKnow($songWeKnow);
        $this->assertTrue($band->knowsAnySong());
    }

    /**
     * @dataProvider getBandsWithKnowSongs
     */
    public function testWeCanGetTheImprescindibleSongsABandKnowsOfAGivenEra(
        $band,
        $era,
        $imprescindible,
        $expectedSongs
    )
    {
        $this->assertEquals($expectedSongs, $band->getSongsWeKnowByEra($era, $imprescindible)->toArray());
    }

    public function getBandsWithKnowSongs()
    {
        $band = Band::withName("Abbey Road");
        $songLoveMedo = Song::withNameAndEra("Love Me Do", SongEra::FIRST_ERA, true);
        $songSheLovesYou = Song::withNameAndEra("She Loves You", SongEra::FIRST_ERA, true);
        $songBabysInBlack = Song::withNameAndEra("Baby's in black", SongEra::FIRST_ERA, false);
        $songMatchbox = Song::withNameAndEra("Matchbox", SongEra::FIRST_ERA, false);
        $band->addSongWeKnow($songLoveMedo);
        $band->addSongWeKnow($songSheLovesYou);
        $band->addSongWeKnow($songBabysInBlack);
        $band->addSongWeKnow($songMatchbox);

        return [
            'With 4 songs of 1 era, 2 imprecindible' => [
                'band' => $band,
                'era' => SongEra::FIRST_ERA,
                'imprescindible' => false,
                'expectedSongs' => [
                    $songLoveMedo,
                    $songSheLovesYou,
                    $songBabysInBlack,
                    $songMatchbox
                ]
            ],
            'With 4 songs of 1 era, 2 imprecindible but only imprescindible' => [
                'band' => $band,
                'era' => SongEra::FIRST_ERA,
                'imprescindible' => true,
                'expectedSongs' => [
                    $songLoveMedo,
                    $songSheLovesYou,
                ]
            ]
        ];
    }
}
