<?php

namespace Tests\Repertoire\Domain;

use Repertoire\Domain\Constant\SongEra;
use Repertoire\Domain\RepertoirePart;
use Repertoire\Domain\Song;

class RepertoirePartTest extends \PHPUnit_Framework_TestCase
{
    public function testWhenItHasAListOfSongsItCanBeIterable()
    {
        $listOfSongs = array(
            Song::withNameAndEra("Let it be", SongEra::THIRD_ERA),
            Song::withNameAndEra("The Long And Winding Road", SongEra::THIRD_ERA)
        );

        $repertoriePart = new RepertoirePart($listOfSongs);

        $counter = 0;

        foreach ($repertoriePart as $song) {
            $this->assertEquals($listOfSongs[$counter++], $song);
        }
    }
}
