<?php

namespace app\components;

use app\models\State;
use Stripe\Card;

class CardStateShortDecorator
{
    /**
     * @param Card|null $card
     * @return Card|null
     */
    public static function decorate($card)
    {
        if (empty($card)) {
            return $card;
        }

        $card->address_state_short = State::getKeyByName((string) $card->address_state);

        return $card;
    }
}