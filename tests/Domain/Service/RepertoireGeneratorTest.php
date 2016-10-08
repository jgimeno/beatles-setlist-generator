<?php

namespace Tests\Repertoire\Domain\Service;

use Doctrine\Common\Collections\ArrayCollection;
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

    public function testItCreatesARepertoireWithOnlyOnePartByDefaultAndTheNumberOfSongsSpecified()
    {
        $band = \Mockery::mock(Band::class);

        $band->shouldReceive('knowsAnySong')
            ->once()
            ->andReturn(true);

        $band->shouldReceive('getSongsWeKnow')
            ->andReturn($this->getBatchOfSongs());

        $repertoire = $this->generator->generateRepertoireFor($band, new RepertoireName("Castañada"), 3);
        $this->assertEquals(1, count($repertoire->getParts()));
    }

    protected function getBatchOfSongs()
    {
        return new ArrayCollection(
            [
                Song::withNameAndEra("Let it be", SongEra::FIRST_ERA),
                Song::withNameAndEra("The Long and winding road", SongEra::FIRST_ERA),
                Song::withNameAndEra("Hey jude", SongEra::FIRST_ERA),
                Song::withNameAndEra("I want to hold your hand", SongEra::FIRST_ERA),
            ]
        );
    }
}
