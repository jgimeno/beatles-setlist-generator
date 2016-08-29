<?php

namespace Repertoire\Application\Persistence;

use Repertoire\Domain\Band;

interface BandRepositoryInterface
{
    public function getBandByName(string $name);

    public function save(Band $band);
}
