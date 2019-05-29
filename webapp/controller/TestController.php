<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;
use Tracy\Debugger;

class TestController extends BaseController {

    function index() {

        //Create new game engine
        $game = new FishGameEngine();

        if(isset($_SESSION['game'])){
            $game = Session::get('game');
        }
        else
        {
            Session::set('game', $game);
        }

        Debugger::barDump($game);
        $game->checkFish();
        return View::make('home.GoFish', ['game' => $game]);
    }

    function play(){
        $game = Session::get('game');
        Debugger::barDump($game);

        //Ask one card
        $card = new Card(Post::get('card'));
        $result = $game->askForCard($card);
        Debugger::barDump($card, "Carta");
        Debugger::barDump($result, "Carta pedida");

        //verificar se carta pedida existe
        if(count($result) == 0){
            //Go fish and change player
            $newCard = $game->goFish();

            if($newCard->getValue() == $card->getValue()){
                Session::set('game', $game);
                return;
            }

            $game->changeCurrentPlayer();

            $botDone = false;
            while(!$botDone) {
                $botCard = $game->makeBotPlay();
                Debugger::barDump($botCard, "Carta pedida pelo bot");

                $botResult = $game->askForCard($botCard);
                if (count($botResult) == 0) {
                    $newCard = $game->goFish();

                    if($newCard->getValue() != $card->getValue()){
                        $game->changeCurrentPlayer();
                        $botDone = true;
                    }
                } else {
                    $game->addCardsToHand($botResult);
                }
            }

            Session::set('game', $game);
        } else {
            $game->addCardsToHand($result);
        }

        Session::set('game', $game);
    }

    function delete() {

        //Create new game engine
        $game = new FishGameEngine();
        Session::set('game', $game);

        Redirect::toRoute('home/GoFish');
    }
}