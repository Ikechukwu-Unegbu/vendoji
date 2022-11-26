<?php

namespace App\Services;

use App\Models\V1\Core\Refrule;

//use Faker\Guesser\Name;

class CalculationService
{
    public function find_x_btc($btc=1, $knownNaira, $btcNairaCurrentVal)
    {
        $x_btc = ($knownNaira*$btc)/$btcNairaCurrentVal;
        $x_btc = $x_btc;
        return $x_btc;
    }

    public function actualRefRewardValue($nairaInvested)
    {
        $refRule = Refrule::find(1);
        $value = ($refRule->reward/100)*$nairaInvested;
        return $value;
    }

    public function adminReward($figureInvested)
    {
        $r = (5/100)*$figureInvested;
        return $r;
    }

    public function percentageLock($balance, $partialLock)
    {
        $cal = $partialLock / 100 * $balance;
        $cal = $balance - $cal;
        return $cal;
    }

    public function adminPercentage($percentage, $amount)
    {
        $amount = $percentage / 100 * $amount;
        return number_format($amount, 8, '.', '');
    }

}
