<?php

/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 11-05-2017
 * Time: 13:09
 */
class Hand
{

    private $_hand = [];

    /**
     * Hand constructor.
     * @param array $initialCards
     */
    public function __construct(array $initialCards) {
        $this->_hand = $initialCards;
        usort($this->_hand,  ['Card','cmp']);
    }

    /**
     * @param array $hand
     */
    //define e ordena as cartas d mão
    public function setHand(array $hand)
    {
        $this->_hand = $hand;
        usort($this->_hand,  ['Card','cmp']);
    }

    public function removeCardsByValue(Card $card){
        //Remove as cartas da mão que tenham o mesmo valor que a carta passada como parâmetro

        foreach($this->_hand as $cardInHand) {
            if ($cardInHand->getValue() == $card->getValue()) {
                $this->_hand = array_diff($this->_hand, [$cardInHand]);
            }
            usort($this->_hand,  ['Card','cmp']);//para evitar que existam posições vazias ou nulas no array
        }
    }

    //adiciona cartas à mão
    public function addCardsToHand(array $cards) {
        $this->_hand = array_merge($this->_hand, $cards);
        usort($this->_hand,  ['Card','cmp']);
    }

    public function removeCardsFromHand(array $cards) {
        $this->_hand = array_diff($this->_hand, $cards);
        usort($this->_hand,  ['Card','cmp']);
    }

    /**
     * @return int
     */
    public function getHandSize() {
        return count($this->_hand);
    }

    /**
     * Recebe uma carta, procura na mão por cartas com o mesmo valor
     * remove-as caso existam e retorna um vetor com as cartas removidas
     * @param Card $card
     * @return array
     */
    public function askCardsInHand(Card $card) {
        $result = [];
        foreach($this->_hand as $cardInHand) {
            if ($cardInHand->getValue() == $card->getValue()) {
                array_push($result, $cardInHand);
            }
        }
        $this->removeCardsByValue($card);

        return $result;
    }

    /**
     * @return array
     */
    public function getHand(): array
    {
        return $this->_hand;
    }

    public function checkFish(){
        $points = 0;

        // 
        for($i = 0; $i < ($this->getHandSize() - 3); $i++){
            if($this->_hand[$i]->getValue() == $this->_hand[$i + 3]->getValue()){
                $this->removeCardsByValue($this->_hand[$i]);

                $i = -1;
                ++$points;
            }
        }
        return $points;
    }
}