<?php

namespace App\Utils;

use Doctrine\Common\Collections\Collection;

class AverageRateCalculator
{
    public function calculate(Collection $ratings):int
    {
        $sumOfRates = null;
        foreach ($ratings as $rating) {
            $sumOfRates += $rating->getScore();
        }

        $numberOfRates = count($ratings);

        return floor($sumOfRates / $numberOfRates);
    }
}
