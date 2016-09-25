<?php

namespace Repertoire\Application\Command;

class GenerateRepertoire
{
    /**
     * @var string The name of the band.
     */
    protected $bandName;

    /**
     * @var string The name of the Repertoire.
     */
    protected $repertoireName;

    /**
     * GenerateRepertoire constructor.
     * @param string $bandName
     * @param string $repertoireName
     */
    public function __construct($bandName, $repertoireName)
    {
        $this->bandName = $bandName;
        $this->repertoireName = $repertoireName;
    }

    /**
     * @return string
     */
    public function getBandName(): string
    {
        return $this->bandName;
    }

    /**
     * @return string
     */
    public function getRepertoireName(): string
    {
        return $this->repertoireName;
    }


}
