<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Repertoire\Application\Command\GenerateRepertoire as GenerateRepertoireCommand;
use Repertoire\Application\Command\Handler\GenerateRepertoireHandler;

class GenerateRepertoire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repertoire:generate {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var GenerateRepertoireHandler
     */
    private $handler;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GenerateRepertoireHandler $handler)
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
        $name = $this->argument('name');

        $command = new GenerateRepertoireCommand("The Beatboys", $name);
        $this->handler->handle($command);
    }
}
