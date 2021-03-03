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



    /*
    private $frais = [
       "0-5000" => 425,
        "5000-10000" => 850,
        "10000-15000" => 1270,
        "15000-20000" => 1695,
        "200000-50000" => 2500,
        "50000-60000" => 3000,
        "60000-75000" => 4000,
        "75000-120000" => 5000,
        "120000-150000" => 6000,
        "150000-200000" => 7000,
        "200000-250000" => 8000,
        "250000-300000" => 9000,
        "300000-400000" => 12000,
        "400000-750000" => 15000,
        "750000-900000" => 22000,
        "900000-1000000" => 25000,
        "1000000-1125000" => 27000,
        "1125000-14000000" => 30000,
        "14000000-2000000" => 30000,
    ];


    public function CalculateCommission($frais)
    {
        $part =[];
        // 40% pour l'Etat
        $part['partEtat'] = ($frais * 40) / 100;
        // 30% pour l'entreprise
        $part['partEntreprise'] = ($frais * 30) / 100;
        // 10% pour l'agence quit fait le transfert
        $part['partAgentDepot'] = ($frais * 10) / 100;
        // 20% pour l'agence qui fait le depot
        $part['partAgentRetrait'] = ($frais * 20) / 100;

        return $part;
    }

    public function CalculateFrais($montant)
    {
        foreach ($this->frais as $key => $value) {
            [$minNomber, $maxNomber] = explode(" ", $key);
            if ($montant >= $minNomber & $montant < $maxNomber){
                return  $value;
            }
        }
        if ($montant > 2000000){
            return ($montant * 2)/100;
        }
    }*/



