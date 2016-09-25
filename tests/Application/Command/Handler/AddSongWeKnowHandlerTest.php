<?php

namespace Tests\Repertoire\Application\Command\Handler;

use Mockery\Adapter\PHPUnit\MockeryTestCase;
use Repertoire\Application\Command\AddSongWeKnow;
use Repertoire\Application\Command\Handler\AddSongWeKnowHandler;
use Repertoire\Application\Persistence\BandRepositoryInterface;
use Repertoire\Domain\Band;
use Repertoire\Domain\Constant\SongEra;
use Repertoire\Domain\Exception\BandAlreadyKnowsSongException;
use Repertoire\Domain\Song;

class AddSongWeKnowHandlerTest extends MockeryTestCase
{
    public function testItSavesANewTheBandWhenItDoesNotExist()
    {
        $command = new AddSongWeKnow("The Beatboys", "Let it be", 1);

        $mockedRepository = \Mockery::mock(BandRepositoryInterface::class);
        $mockedRepository->shouldReceive('getBandByName')
            ->once()
            ->with('The Beatboys')
            ->andReturn(null);

        $mockedRepository->shouldReceive('save')
            ->once()
            ->with(\Mockery::on(function (Band $arg) {
                $this->assertInstanceOf(Band::class, $arg);
                $this->assertEquals("The Beatboys", $arg->getName());
                $this->assertTrue($arg->knowsSong(Song::withNameAndEra("Let it be", SongEra::THIRD_ERA)));
                return true;
            }));

        $commandHandler = new AddSongWeKnowHandler($mockedRepository);
        $commandHandler->execute($command);
    }

    public function testItShouldNotCreateAnotherBandWhenBandExists()
    {
        $command = new AddSongWeKnow("The Beatboys", "Let it be", 3);

        $existingBand = Band::withName("The Beatboys");

        $mockedRepository = \Mockery::mock(BandRepositoryInterface::class);
        $mockedRepository->shouldReceive('getBandByName')
            ->once()
            ->with('The Beatboys')
            ->andReturn($existingBand);

        $mockedRepository->shouldReceive('save')
            ->once()
            ->with($existingBand);

        $commandHandler = new AddSongWeKnowHandler($mockedRepository);
        $commandHandler->execute($command);
    }

    public function testItShouldNotSaveWhenBandKnowsThatSongAlready()
    {
        $this->expectException(BandAlreadyKnowsSongException::class);

        $command = new AddSongWeKnow("The Beatboys", "Let it be", 3);

        $existingBand = Band::withName("The Beatboys");
        $existingBand->addSongWeKnow(Song::withNameAndEra("Let it be", SongEra::THIRD_ERA));

        $mockedRepository = \Mockery::mock(BandRepositoryInterface::class);
        $mockedRepository->shouldReceive('getBandByName')
            ->once()
            ->with('The Beatboys')
            ->andReturn($existingBand);

        $mockedRepository->shouldReceive('save')
            ->never();

        $commandHandler = new AddSongWeKnowHandler($mockedRepository);
        $commandHandler->execute($command);
    }

    public function testWeCanDefineASongAsEssential()
    {
        $isEssential = true;

        $command = new AddSongWeKnow("The Beatboys", "Let it be", 1, $isEssential);

        $mockedRepository = \Mockery::mock(BandRepositoryInterface::class);
        $mockedRepository->shouldReceive('getBandByName')
            ->once()
            ->with('The Beatboys')
            ->andReturn(null);

        $mockedRepository->shouldReceive('save')
            ->once()
            ->with(\Mockery::on(function (Band $arg) {
                $this->assertInstanceOf(Band::class, $arg);
                $this->assertEquals("The Beatboys", $arg->getName());
                $this->assertTrue($arg->knowsSong(Song::withNameAndEra("Let it be", SongEra::THIRD_ERA)));

                $songsWeKnow = $arg->getSongsWeKnow();
                $song = $songsWeKnow->first();
                $this->assertTrue($song->isEssential());

                return true;
            }));

        $commandHandler = new AddSongWeKnowHandler($mockedRepository);
        $commandHandler->execute($command);
    }
}
