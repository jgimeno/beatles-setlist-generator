<?php

namespace Tests\Repertoire\Domain\Service;

use Repertoire\Domain\Band;
use Repertoire\Domain\Constant\SongEra;
use Repertoire\Domain\Exception\BandDoesNotKnowSongsException;
use Repertoire\Domain\Repertoire;
use Repertoire\Domain\Service\RepertoireGenerator;
use Repertoire\Domain\Song;
use Repertoire\Domain\Value\RepertoireName;

class RepertoireGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RepertoireGenerator
     */
    protected $generator;

    protected function setUp()
    {
        parent::setUp();
        $this->generator = new RepertoireGenerator();
    }


    public function testItInstantiatesCorrectly()
    {
        $this->assertInstanceOf(RepertoireGenerator::class, $this->generator);
    }

    public function testItGeneratesARepertoireForAGivenGroup()
    {
        $band = Band::withName("The beatboys");
        $band->addSongWeKnow(Song::withNameAndEra("The long and winding road", SongEra::THIRD_ERA));

        $repertoire = $this->generator->generateRepertoireFor(
            $band,
            new RepertoireName("Castañada")
        );

        $this->assertInstanceOf(Repertoire::class, $repertoire);
        $this->assertEquals("Castañada", $repertoire->getName());
    }

    public function testItThrowsExceptionWhenABandDoesNotKnowAnySong()
    {
        $this->expectException(BandDoesNotKnowSongsException::class);
        $this->generator->generateRepertoireFor(
            Band::withName("The Beatboys"),
            new RepertoireName("Castañada")
        );
    }
}
