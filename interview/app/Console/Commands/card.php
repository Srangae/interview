<?php

namespace App\Console\Commands;

use App\Services\CardGameService;
use Illuminate\Console\Command;

class card extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'card:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Card Playing Games';

    private $gameService;

    /**
     * Create a new command instance.
     *
     * @param CardGameService $gameService
     */
    public function __construct(CardGameService $gameService)
    {
        parent::__construct();
        $this->gameService = $gameService;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('Welcome to Card Playing Game.');

        $numberOfPlayers = $this->ask('Please input numbers of players. (minimum 1 player and maximum 52 players)');

        $this->info('Validating number of players ...');

        $validation = $this->gameService->validateNumberOfPlayer($numberOfPlayers);

        if($validation->fails()) {
            $this->error('Input value does not exist or value is invalid');
            exit();
        }

        if($this->gameService->validateIrregularity($numberOfPlayers) === false) {
            $this->error('Irregularity occurred');
            exit();
        };

        $this->line('Game starting ...');
        $this->info('Dealing card to players ...');
        $gameStart = $this->gameService->game($numberOfPlayers);
        $this->line('Players\' card output : ');
        $this->info($gameStart);
        $this->line('End of game ...');
    }
}
