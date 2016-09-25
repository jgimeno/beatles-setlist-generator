<?php

namespace Tests\Repertoire\Domain;

use Repertoire\Domain\Song;
use Repertoire\Domain\Value\Identifier\SongId;
use Repertoire\Domain\Value\SongName;

class SongTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testASongNeedsMinimumAnIdAndAName()
    {
        $song = new Song();
    }

    public function testASongByDefaultIsNotEssential()
    {
        $song = new Song(SongId::generate(), new SongName("The Long and Winding Road"));
        $this->assertFalse($song->isEssential());
    }

    public function testItCanBeCreatedDirectlyUsingNewWithName()
    {
        $song = Song::withName("Let it be");
        $this->assertEquals("Let it be", $song->getName());
    }

    public function testASongWithSameNameIsEqualToASong()
    {
        $song = Song::withName("The Long And Winding Road");

        $sameSong = Song::withName("The Long And Winding Road");

        $anotherSong = Song::withName("A Hard Day's Night");

        $this->assertTrue($song->isEqual($sameSong));
        $this->assertFalse($song->isEqual($anotherSong));
    }

    public function testWeCanDefineASongAsImprescindible()
    {
        $song = Song::withName("", true);
        $this->assertTrue($song->isEssential());
    }
}
