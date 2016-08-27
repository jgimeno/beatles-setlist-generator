<?php

namespace Tests\Repertoire\Domain;

use Repertoire\Domain\Repertoire;
use Repertoire\Domain\RepertoirePart;
use Repertoire\Domain\Value\Identifier\RepertoireId;
use Repertoire\Domain\Value\RepertoireName;

class RepertoireTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRepertoireMustHaveNameAndId()
    {
        new Repertoire();
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRepertoireNeedsAnId()
    {
        new Repertoire(null, new RepertoireName("Castañada 2010"));
    }

    public function testARepertoryCanHaveOneOrMultipleParts()
    {
        $repertoire = Repertoire::withName("Castañada 2011");

        $part1 = new RepertoirePart();

        $repertoire->addPart($part1);

        $this->assertEquals($repertoire->getParts(), [$part1]);
    }
}
