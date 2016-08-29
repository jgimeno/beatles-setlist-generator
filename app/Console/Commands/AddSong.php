<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Repertoire\Application\Command\AddSongWeKnow;
use Repertoire\Application\Command\Handler\AddSongWeKnowHandler;

class AddSong extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repertoire:addSong {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a song you know in the repertoire.';

    /**
     * @var AddSongWeKnowHandler the handler that does all the magic.
     */
    private $handler;

    /**
     * Create a new command instance.
     *
     * @param AddSongWeKnowHandler $handler
     */
    public function __construct(AddSongWeKnowHandler $handler)
    {
        parent::__construct();
        $this->handler = $handler;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $songName = $this->argument('name');
        $this->handler->execute(new AddSongWeKnow("The Beatboys", $songName));
    }
}
