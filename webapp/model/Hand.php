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
    public function setHand(array $hand)
    {
        $this->_hand = $hand;
        usort($this->_hand,  ['Card','cmp']);
    }

    public function removeCardsByValue(Card $card){
        // TODO: Remove as cartas da mão que tenham o mesmo valor que a carta passada como parâmetro

        foreach($this->_hand as $cardInHand) {
            if ($cardInHand->getValue() == $card->getValue()) {
                $this->_hand = array_diff($this->_hand, [$cardInHand]);
            }
            usort($this->_hand,  ['Card','cmp']);
        }
    }

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


}