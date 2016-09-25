<?php

namespace Tests\Repertoire\Application\Command\Handler;

use Mockery\Adapter\PHPUnit\MockeryTestCase;
use Repertoire\Application\Command\AddSongWeKnow;
use Repertoire\Application\Command\Handler\AddSongWeKnowHandler;
use Repertoire\Application\Persistence\BandRepositoryInterface;
use Repertoire\Domain\Band;
use Repertoire\Domain\Exception\BandAlreadyKnowsSongException;
use Repertoire\Domain\Song;

class AddSongWeKnowHandlerTest extends MockeryTestCase
{
    public function testItSavesANewTheBandWhenItDoesNotExist()
    {
        $command = new AddSongWeKnow("The Beatboys", "Let it be");

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
                $this->assertTrue($arg->knowsSong(Song::withName("Let it be")));
                return true;
            }));

        $commandHandler = new AddSongWeKnowHandler($mockedRepository);
        $commandHandler->execute($command);
    }

    public function testItShouldNotCreateAnotherBandWhenBandExists()
    {
        $command = new AddSongWeKnow("The Beatboys", "Let it be");

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

        $command = new AddSongWeKnow("The Beatboys", "Let it be");

        $existingBand = Band::withName("The Beatboys");
        $existingBand->addSongWeKnow(Song::withName("Let it be"));

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

        $command = new AddSongWeKnow("The Beatboys", "Let it be", $isEssential);

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
                $this->assertTrue($arg->knowsSong(Song::withName("Let it be")));

                $songsWeKnow = $arg->getSongsWeKnow();
                $song = $songsWeKnow->first();
                $this->assertTrue($song->isEssential());

                return true;
            }));

        $commandHandler = new AddSongWeKnowHandler($mockedRepository);
        $commandHandler->execute($command);
    }
}
