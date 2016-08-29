<?php

namespace Tests\Repertoire\Domain;

use Repertoire\Domain\Band;

class BandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testABandMustHaveAtLeastNameAndId()
    {
        new Band();
    }
}
