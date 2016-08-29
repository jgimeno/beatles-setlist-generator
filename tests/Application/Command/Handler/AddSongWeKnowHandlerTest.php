<?php

namespace Tests\Repertoire\Application\Command\Handler;

use Mockery\Adapter\PHPUnit\MockeryTestCase;
use Repertoire\Application\Command\AddSongWeKnow;
use Repertoire\Application\Command\Handler\AddSongWeKnowHandler;
use Repertoire\Application\Persistence\BandRepositoryInterface;
use Repertoire\Domain\Band;

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
            ->once();

        $commandHandler = new AddSongWeKnowHandler($mockedRepository);
        $commandHandler->execute($command);
    }

    public function itShouldNotSaveWhenBandExistsInRepository()
    {
        $command = new AddSongWeKnow("The Beatboys", "Let it be");

        $mockedRepository = \Mockery::mock(BandRepositoryInterface::class);
        $mockedRepository->shouldReceive('getBandByName')
            ->once()
            ->with('The Beatboys')
            ->andReturn(Band::withName("The Beatboys"));

        $mockedRepository->shouldReceive('save')
            ->never();

        $commandHandler = new AddSongWeKnowHandler($mockedRepository);
        $commandHandler->execute($command);
    }
}
