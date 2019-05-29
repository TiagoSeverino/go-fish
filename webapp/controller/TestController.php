<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;


class TestController extends BaseController {

    function index() {

        //Create new game engine
        $game = new FishGameEngine();
        \Tracy\Debugger::barDump($game);

        //Ask one card
        $card = new Card(7);
        $result = $game->askForCard($card);
        \Tracy\Debugger::barDump($result, "Carta pedida");


        //verificar se carta pedida existe
        if(count($result) == 0){
            //Go fish and change player
            $game->goFish();
            $game->changeCurrentPlayer();
        } else {
            $card = new Card(20);
            $result = $game->askForCard($card);
            \Tracy\Debugger::barDump($result, "Carta pedida");
            $game->goFish();
            $game->changeCurrentPlayer();
        }

        //
        if (count($result) == 0) {
            $botDone = false;
            while(!$botDone) {
                $botCard = $game->makeBotPlay();
                \Tracy\Debugger::barDump($botCard, "Carta pedida pelo bot");


                $botResult = $game->askForCard($botCard);
                if (count($botResult) == 0) {
                    $game->goFish();
                    $game->changeCurrentPlayer();
                    $botDone = true;
                } else {
                    $game->addCardsToHand($botResult);
                }
            }
        } else {
            $game->addCardsToHand($result);
        }
        
        return View::make('home.GoFish', ['game' => $game]);
    }

}