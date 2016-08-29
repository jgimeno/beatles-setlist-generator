<?php

namespace Repertoire\Application\Command;

class AddSongWeKnow
{
    /**
     * @var string
     */
    private $bandName;

    /**
     * @var string
     */
    private $songName;

    public function __construct(string $bandName, string $songName)
    {
        $this->bandName = $bandName;
        $this->songName = $songName;
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
    public function getSongName(): string
    {
        return $this->songName;
    }
}
