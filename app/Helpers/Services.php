<?php

namespace App\Helpers;

class Services
{
    public static function getPercentChange($oldNumber, $newNumber)
    {
        if ($oldNumber == 0) {
            return (float) 0;
        } else {
            $changeValue = $newNumber - $oldNumber;

            return (float) ($changeValue / $oldNumber) * 100;
        }
    }
}
