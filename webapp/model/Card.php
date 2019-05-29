<?php

class Card {

    private $_identifier;
    /**
     * Card constructor.
     */
    public function __construct($identifier) {
        $this->_identifier = $identifier;
    }

    public function getIdentifier() {
        return $this->_identifier;
    }

    public function getValue() {
        return substr($this->_identifier, 1);
    }

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