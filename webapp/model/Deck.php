<?php

/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 10-05-2017
 * Time: 13:58
 */
class Deck
{
    public $_deck = [];
    
    public function __construct()
    {
        $this->openDeck();
        $this->shuffleDeck();
    }

    protected function openDeck(){

        //load cards in _deck
        //for diamonds
        for ($i = 2; $i <= 14; $i++){
            array_push($this->_deck, new Card('D' . $i));
        }

        //for clubs
        for ($i = 2; $i <= 14; $i++){
            array_push($this->_deck, new Card('C' . $i));
        }

        //for hearts
        for ($i = 2; $i <= 14; $i++){
            array_push($this->_deck, new Card('H' . $i));
        }

        //for spades
        for ($i = 2; $i <= 14; $i++){
            array_push($this->_deck, new Card('S' . $i));
        }
    }

    protected function shuffleDeck() {
        shuffle($this->_deck);
    }


    /**
     * @return array
     */
    public function getDeck(): array {
        return $this->_deck;
    }

    /**
     * @param $numCards number of cards to deal
     * @return array
     */
    public function dealCards($numCards) {
        $numCardsInDeck = count($this->_deck);
        if ($numCardsInDeck == 0) {
            return null;
        }

        if ($numCardsInDeck < $numCards) {
            $temp = $this->_deck;
            $this->_deck = [];
            return $temp;
        }

        return array_splice($this->_deck, 0, $numCards);
    }

    public function getCurrentDeckSize() {
        return count($this->_deck);
    }
}