<?php

namespace Tests\Repertoire\Domain\Value\Identifier;

use Repertoire\Domain\Value\Identifier\Identifier;

class IdentifierTest extends \PHPUnit_Framework_TestCase
{
    public function testWhenGeneratingIdItMustBeUnique()
    {
        $id1 = Identifier::generate();
        $id2 = Identifier::generate();

        $this->assertNotEquals($id1, $id2);
    }
}
