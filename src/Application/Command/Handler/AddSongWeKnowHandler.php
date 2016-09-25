<?php

namespace Repertoire\Application\Command\Handler;

use Repertoire\Application\Command\AddSongWeKnow;
use Repertoire\Application\Persistence\BandRepositoryInterface;
use Repertoire\Domain\Band;
use Repertoire\Domain\Song;

class AddSongWeKnowHandler
{
    /**
     * @var BandRepositoryInterface
     */
    private $bandRepository;

    public function __construct(BandRepositoryInterface $bandRepository)
    {
        $this->bandRepository = $bandRepository;
    }

    public function execute(AddSongWeKnow $command)
    {
        $bandName = $command->getBandName();
        $songName = $command->getSongName();
        $isEssential = $command->isEssential();

        $band = $this->bandRepository->getBandByName($bandName);

        if (!$band) {
            $band = Band::withName($bandName);
        }

        $song = Song::withName($songName, $isEssential);
        $band->addSongWeKnow($song);
        $this->bandRepository->save($band);
    }
}
