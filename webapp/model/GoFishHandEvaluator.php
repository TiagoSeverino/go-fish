<?php

/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 11-05-2017
 * Time: 12:58
 */
class GoFishHandEvaluator implements GoFishHandEvaluatorInterface
{
    public static function checkFish(Hand $hand){
        $inHand = [];
        $pointMade = false;
        foreach($hand->getHand() as $card) {
            array_push($inHand, $card->getValue());
        }
        $numRep = array_count_values($inHand);
        foreach ($numRep as $value) {
            if ($value == 4) {
                $pointMade = true;
            }
        }
        return $pointMade;
    }
}