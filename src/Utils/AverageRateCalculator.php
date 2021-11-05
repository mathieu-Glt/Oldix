<?php

namespace App\Utils;

use Doctrine\Common\Collections\Collection;

class AverageRateCalculator
{   
    /**
     * toto
     *
     * @param Collection $ratings
     * @return integer
     */
    public function calculate(Collection $ratings):int
    {
        $sumOfRates = null;
        foreach ($ratings as $rating) {
            $sumOfRates += $rating->getScore();
        }
        
        $numberOfRates = count($ratings);
        if($numberOfRates === 0 ){
            return 0;
        }else{
            return floor($sumOfRates / $numberOfRates);
        }
    }
}
