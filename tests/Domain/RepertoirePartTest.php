<?php

namespace Tests\Repertoire\Domain;

use Repertoire\Domain\RepertoirePart;
use Repertoire\Domain\Song;

class RepertoirePartTest extends \PHPUnit_Framework_TestCase
{
    public function testWhenItHasAListOfSongsItCanBeIterable()
    {
        $listOfSongs = array(
            Song::withName("Let it be"),
            Song::withName("The Long And Winding Road")
        );

        $repertoriePart = new RepertoirePart($listOfSongs);

        $counter = 0;

        foreach ($repertoriePart as $song) {
            $this->assertEquals($listOfSongs[$counter++], $song);
        }
    }
}
