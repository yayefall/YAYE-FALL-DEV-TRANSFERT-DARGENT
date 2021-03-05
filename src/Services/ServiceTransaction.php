<?php

namespace App\Services;


Class ServiceTransaction
{


    public function getFrais($montant)
    {
        $max_array = [5000, 10000, 15000, 20000, 50000, 60000, 75000, 120000, 150000, 200000,
            250000, 300000, 400000, 750000, 900000, 1000000, 1125000, 1400000, 2000000];
        $frais_array = [425, 850, 1270, 1695, 2500, 3000, 4000, 5000, 6000,
            7000, 8000, 9000, 1200, 15000, 22000, 25000, 27000, 30000, 30000];

        for ($i = 0; $i < count($max_array); $i++) {
            if ($montant <= $max_array[$i]) {
                return $frais_array[$i];
            }
            if ($montant > 2000000) {
                return ($montant * 2) / 100;
            }
        }

    }

    private function getRandomNumber()
    {
        $randNumber = random_int(100,999);
        if ($randNumber < 10){
            $randNumber = "00".$randNumber;
        }elseif ($randNumber >= 10 &  $randNumber< 100){
            $randNumber = "0".$randNumber;
        }
        return $randNumber;
    }

    public function createCode()
    {
        $x= $this->getRandomNumber();
        $y= $this->getRandomNumber();
        $z= $this->getRandomNumber();
        return   "$x-$y-$z";

    }
    public function generteCode(){
     return strtoupper(substr(uniqid('SA_'.true), 0,12));
    }

}





