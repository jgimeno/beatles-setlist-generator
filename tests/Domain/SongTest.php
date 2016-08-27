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
}
