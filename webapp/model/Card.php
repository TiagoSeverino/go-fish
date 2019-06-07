<?php

class Card {

    private $_identifier;
    /**
     * Card constructor.
     */
    public function __construct($identifier) {
        $this->_identifier = $identifier;
    }

    //devolver o identificador da carta (valor e naipe)
    public function getIdentifier() {
        return $this->_identifier;
    }

    //devolve o valor da carta
    public function getValue() {
        return substr($this->_identifier, 1);
    }

    //comparação do valor de duas cartas, ordenando-as consoante o seu valor crescente
    public static function cmp(Card $a, Card $b)
    {        
        if ($a->getValue() == $b->getValue()) 
            return 0;
        return $a->getValue() > $b->getValue();
    }

    public function __toString()
    {
        return $this->getValue();
    }
}