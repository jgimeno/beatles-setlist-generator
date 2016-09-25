<?php

namespace Tests\Repertoire\Domain;

use Repertoire\Domain\Constant\SongEra;
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
        $song = new Song(SongId::generate(), new SongName("The Long and Winding Road"), SongEra::THIRD_ERA);
        $this->assertFalse($song->isEssential());
    }

    public function testItCanBeCreatedDirectlyUsingNewWithName()
    {
        $song = Song::withNameAndEra("Let it be", SongEra::THIRD_ERA);
        $this->assertEquals("Let it be", $song->getName());
    }

    public function testASongWithSameNameIsEqualToASong()
    {
        $song = Song::withNameAndEra("The Long And Winding Road", SongEra::THIRD_ERA);

        $sameSong = Song::withNameAndEra("The Long And Winding Road", SongEra::THIRD_ERA);

        $anotherSong = Song::withNameAndEra("A Hard Day's Night", SongEra::FIRST_ERA);

        $this->assertTrue($song->isEqual($sameSong));
        $this->assertFalse($song->isEqual($anotherSong));
    }

    public function testWeCanDefineASongAsImprescindible()
    {
        $song = Song::withNameAndEra("", SongEra::FIRST_ERA, true);
        $this->assertTrue($song->isEssential());
    }
}
