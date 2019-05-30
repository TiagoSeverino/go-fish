<?php
use RedBeanPHP\Logger\RDefault\Debug;
use Tracy\Debugger;

class FishGameEngine {
    private $_playerHand;
    private $_botHand;
    private $_playerPoints = 0;
    private $_botPoints = 0;
    private $_playerTurn = true;
    private $_deck;
    private $_startingCardCount;
    private $_finished = false;
    private $_debug = false;

    public function __construct($startingCardCount = 4){
        $this->_startingCardCount = $startingCardCount;

        $this->_deck = new Deck();
        $this->initHands();
    }

    private function initHands() {
        $this->_playerHand = new Hand($this->_deck->dealCards($this->_startingCardCount));
        $this->_botHand = new Hand($this->_deck->dealCards($this->_startingCardCount));
    }

    public function getDeck() {
        return $this->_deck->getDeck();
    }

    public function getPlayerHand() {
        return $this->_playerHand->getHand();
    }

    public function getBotHand() {
        return $this->_botHand->getHand();
    }

    public function getPlayerPoints() {
        return $this->_playerPoints;
    }

    public function getBotPoints() {
        return $this->_botPoints;
    }

    public function addCardsToHand(array $cards) {
        if ($this->_playerTurn) {
            $this->_playerHand->addCardsToHand($cards);
        } else {
            $this->_botHand->addCardsToHand($cards);
        }

        $this->checkFish();
    }
        
    public function getBotCardCount() {
        return $this->_botHand->getHandSize();
    }

    public function getPlayerCardCount() {
        return $this->_playerHand->getHandSize();
    }

    public function getDeckCardCount() {
        return $this->_deck->getCurrentDeckSize();
    }

    public function isFinished() {
        return $this->_finished;
    }

    public function isDebug() {
        return $this->_debug;
    }

    /**
     * Recebe uma carta, procura na mão por cartas com o mesmo valor
     * remove-as caso existam e retorna um vetor com as cartas removidas
     * @param Card $card
     * @return array
     */
    public function askForCard(Card $card) : array {
        if ($this->_playerTurn)
            return $this->_botHand->askCardsInHand($card);
        else
            return $this->_playerHand->askCardsInHand($card);
    }

    public function checkFish(){

        for($i = 0; $i < ($this->getPlayerCardCount() - 3) && $this->getPlayerCardCount() > 3; $i++){
            if($this->getPlayerHand()[$i]->getValue() == $this->getPlayerHand()[$i + 3]->getValue()){

                $hand = $this->getPlayerHand();

                $fish = array_splice($hand, $i, 4);

                $this->_playerHand->removeCardsFromHand($fish);

                $i = 0;
                ++$this->_playerPoints;

            }
        }

        for($i = 0; $i < ($this->getBotCardCount() - 3) && $this->getBotCardCount() > 3; $i++){
            if($this->getBotHand()[$i]->getValue() == $this->getBotHand()[$i + 3]->getValue()){

                $hand = $this->getBotHand();

                $fish = array_splice($hand, $i, 4);

                $this->_botHand->removeCardsFromHand($fish);

                $i = 0;
                ++$this->_botPoints;

            }
        }

        if ($this->getPlayerCardCount() == 0){
            $deal = $this->_deck->dealCards($this->_startingCardCount);

            if ($deal != null)
                $this->_playerHand = new Hand($deal);
        }

        if ($this->getBotCardCount() == 0){
            $deal = $this->_deck->dealCards($this->_startingCardCount);

            if ($deal != null)
                $this->_botHand = new Hand($deal);
        }

        if ($this->getPlayerCardCount() == 0 && $this->getBotCardCount() == 0){
            $this->_finished = true;
        }
    }

    public function goFish() {
        $card = $this->_deck->dealCards(1)[0];
        if ($card == null)
            return $card;

        if ($this->_playerTurn) {
            $this->_playerHand->addCardsToHand([$card]);
        } else {
            $this->_botHand->addCardsToHand([$card]);
        }

        $this->checkFish();

        return $card;
    }

    public function changeCurrentPlayer() {
        $this->_playerTurn = !$this->_playerTurn;
    }

    public function makeBotPlay() {
        return ($this->getBotCardCount() > 0) ? $this->getBotHand()[array_rand($this->getBotHand())] : null;
    }
}