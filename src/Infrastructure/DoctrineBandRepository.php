<?php

namespace Repertoire\Infrastructure;

use Doctrine\ORM\EntityManager;
use Repertoire\Application\Persistence\BandRepositoryInterface;
use Repertoire\Domain\Band;

class DoctrineBandRepository implements BandRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getBandByName(string $name)
    {
        return $this->em->getRepository(Band::class)->findOneByName($name);
    }

    public function save(Band $band)
    {
        $this->em->persist($band);
        $this->em->flush();
    }
}
