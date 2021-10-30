<?php

namespace App\Utils;

class RunTimeFormatter
{
    public function formatHour(string $time): string
    {
        $time = intval($time);
        if ($time < 60) {
            return $time . ' min';
        }

        $hasMinute = $time % 60;
        if ($hasMinute === 0) {
            return $time/60 . ' h';
        }

        $nbrHour = floor($time / 60);
        $nbrMinutes = $time % 60;
        return $nbrHour . ' h ' . $nbrMinutes . ' min';
    }
}
