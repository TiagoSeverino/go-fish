<?php

/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 10-05-2017
 * Time: 13:58
 */
class Deck
{
    //cria um array vazio
    private $_deck = [];
    
    //construtor: abre o deck de cartas e baralha as mesmas
    public function __construct()
    {
        $this->openDeck();
        $this->shuffleDeck();
    }

    //método para criar o baralho, dividindo as cartas por naipe
    protected function openDeck(){

        //load cards in _deck
        //for diamonds
        for ($i = 1; $i <= 13; $i++){
            array_push($this->_deck, new Card('D' . $i));
        }

        //for clubs
        for ($i = 1; $i <= 13; $i++){
            array_push($this->_deck, new Card('C' . $i));
        }

        //for hearts
        for ($i = 1; $i <= 13; $i++){
            array_push($this->_deck, new Card('H' . $i));
        }

        //for spades
        for ($i = 1; $i <= 13; $i++){
            array_push($this->_deck, new Card('S' . $i));
        }
    }

    //método para baralhar as cartas
    protected function shuffleDeck() {
        shuffle($this->_deck);
    }


    /**
     * @return array
     */

     //devolve o array criado com as cartas
    public function getDeck(): array {
        return $this->_deck;
    }

    /**
     * @param $numCards number of cards to deal
     * @return array
     */
    //distribui as cartas
    public function dealCards($numCards) {
        $numCardsInDeck = count($this->_deck);
        if ($numCardsInDeck == 0) {
            return null;
        }
        //se tiver menos cartas no baralho do que as que foram pedidas devolve todas as cartas
        if ($numCardsInDeck < $numCards) {
            $temp = $this->_deck;
            $this->_deck = [];
            return $temp;
        }

        //devolve o número de cartas pedidas($numCards)
        return array_splice($this->_deck, 0, $numCards);
    }

    //devolve a quantidade de cartas no baralho
    public function getCurrentDeckSize() {
        return count($this->_deck);
    }
}