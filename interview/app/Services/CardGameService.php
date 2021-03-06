<?php

    namespace App\Services;

    use Illuminate\Support\Facades\Validator;

    class CardGameService
	{
        /**
         * @var array
         */
        private $cardDeck;

        public function __construct()
        {
            $this->cardDeck = collect([
              'S-A', 'S-2', 'S-3', 'S-4', 'S-5', 'S-6', 'S-7', 'S-8', 'S-9', 'S-X', 'S-J', 'S-Q', 'S-K',
              'H-A', 'H-2', 'H-3', 'H-4', 'H-5', 'H-6', 'H-7', 'H-8', 'H-9', 'H-X', 'H-J', 'H-Q', 'H-K',
              'C-A', 'C-2', 'C-3', 'C-4', 'C-5', 'C-6', 'C-7', 'C-8', 'C-9', 'C-X', 'C-J', 'C-Q', 'C-K',
              'D-A', 'D-2', 'D-3', 'D-4', 'D-5', 'D-6', 'D-7', 'D-8', 'D-9', 'D-X', 'D-J', 'D-Q', 'D-K',
            ]);
        }

        /**
         * Players must no exceed 52 players.
         */
        public function validateNumberOfPlayer($players)
        {
            return Validator::make([$players], ['numeric|min:1']);
	    }

        public function validateIrregularity($players)
        {
            #1. Check for irregular card number

            $cardNeedToDealt = 52 / $players;

            if($players < 53 && !is_integer($cardNeedToDealt)) {
                return false;
            }
	    }

        public function game($numberOfPlayers)
        {
            #1. shuffle Deck
            $shuffledDeck = $this->cardDeck->shuffle();

            #2. Deal card to players.
            $dealtCard = $shuffledDeck->split($numberOfPlayers);

            $dealtCard->transform(function($value){
                return $value->implode('');
            });

            return $dealtCard->implode(',');
	    }

	}
