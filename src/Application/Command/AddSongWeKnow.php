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

    /**
     * @var bool
     */
    private $essential;

    public function __construct(string $bandName, string $songName, bool $essential = false)
    {
        $this->bandName = $bandName;
        $this->songName = $songName;
        $this->essential = $essential;
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

    /**
     * @return boolean
     */
    public function isEssential(): bool
    {
        return $this->essential;
    }
}
