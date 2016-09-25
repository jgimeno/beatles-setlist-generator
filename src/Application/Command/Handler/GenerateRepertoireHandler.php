<?php

namespace Repertoire\Application\Command\Handler;

use Repertoire\Application\Command\GenerateRepertoire;
use Repertoire\Application\Persistence\BandRepositoryInterface;
use Repertoire\Domain\Exception\BandDoesNotExistException;
use Repertoire\Domain\Repertoire;

class GenerateRepertoireHandler
{
    /**
     * @var BandRepositoryInterface
     */
    private $bandRepository;

    /**
     * GenerateRepertoireHandler constructor.
     * @param BandRepositoryInterface $bandRepository
     */
    public function __construct(BandRepositoryInterface $bandRepository)
    {

        $this->bandRepository = $bandRepository;
    }

    public function handle(GenerateRepertoire $command)
    {
        $repertoireName = $command->getRepertoireName();
        $bandName = $command->getBandName();

        $band = $this->bandRepository->getBandByName($bandName);

        if (!$band) {
            throw new BandDoesNotExistException("The Band $bandName does not exist.");
        }

        $repertoire = Repertoire::withName($repertoireName);

        $band->addRepertoire($repertoire);

        $this->bandRepository->save($band);
    }
}
