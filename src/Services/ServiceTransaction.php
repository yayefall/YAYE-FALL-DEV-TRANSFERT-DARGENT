<?php

namespace App\Services;


class ServiceTransaction
{


    public function getFrais($montant)
    {
        $max_array = [
            5000, 10000, 15000, 20000, 50000, 60000, 75000, 120000, 150000, 200000,
            250000, 300000, 400000, 750000, 900000, 1000000, 1125000, 1400000, 2000000
        ];
        $frais_array = [
            425, 850, 1270, 1695, 2500, 3000, 4000, 5000, 6000,
            7000, 8000, 9000, 12000, 15000, 22000, 25000, 27000, 30000, 30000
        ];

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
        $randNumber = random_int(100, 999);
        if ($randNumber < 10) {
            $randNumber = "00" . $randNumber;
        } elseif ($randNumber >= 10 &  $randNumber < 100) {
            $randNumber = "0" . $randNumber;
        }
        return $randNumber;
    }

    public function createCode()
    {
        $x = $this->getRandomNumber();
        $y = $this->getRandomNumber();
        $z = $this->getRandomNumber();
        return   "$x-$y-$z";
    }
    public function generteCode(): string
    {
        return strtoupper(substr(uniqid('SA_' . true), 0, 12));
    }

    public function envoieSms($montant , $nom , $code )
    {

        $sid = "AC4598fd9103c01b1214f6eae0d2eecf35"; // Your Account SID from www.twilio.com/console
        $token = "71c9bb2ea4df8554cc709a94c734faea"; // Your Auth Token from www.twilio.com/console

        $client = new \Twilio\Rest\Client($sid, $token);
        $message = $client->messages->create(
            '+221777756542', // Text this number
            [
                'from' => '+14159972980', // From a valid Twilio number
                'body' => 'Vous avez recu une somme de '.$montant.'  fcfa de '.$nom.' ,votre code est '.$code,
            ]
        );

        print $message->sid;
    }
}
