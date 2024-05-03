<?php

namespace App\Service;

use Faker\Provider\fr_FR\Address as frAddress;
use Faker\Provider\fr_FR\Person as frPerson;
use Faker\Provider\fr_FR\PhoneNumber as frPhoneNumber;
use Faker\Provider\ru_RU\Address as ruAddress;
use Faker\Provider\ru_RU\Person as ruPerson;
use Faker\Provider\ru_RU\PhoneNumber as ruPhoneNumber;
use Faker\Provider\en_US\Address as enAddress;
use Faker\Provider\en_US\Person as enPerson;
use Faker\Provider\en_US\PhoneNumber as enPhoneNumber;
use Faker\Factory;



class DataGenerator
{
    protected \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function generateData(?string $region, float|int $errors, int|string|null $seed): array
    {
        mt_srand($seed);
        $this->faker->seed($seed);
        $this->setRegion($region);
        $userData = [];

        for ($i = 0; $i < 3; ++$i) {
            $userData[] = $this->introduceErrors([
                //        'id' => $i,
                //        'uuid' =>  $faker->uuid(),
                'name' => $this->faker->name(),
                'address' => $this->faker->address(),
                'phoneNumber' => $this->faker->phoneNumber(),
            ], $errors);
        }

        return $userData;
    }

    public function setRegion(?string $region): void
    {
        switch ($region) {
            case 'FR':
                $this->faker->addProvider(new frPerson($this->faker));
                $this->faker->addProvider(new frAddress($this->faker));
                $this->faker->addProvider(new frPhoneNumber($this->faker));
                break;
            case 'RU':
                $this->faker->addProvider(new ruPerson($this->faker));
                $this->faker->addProvider(new ruAddress($this->faker));
                $this->faker->addProvider(new ruPhoneNumber($this->faker));
                break;
            case 'EN':
                $this->faker->addProvider(new enPerson($this->faker));
                $this->faker->addProvider(new enAddress($this->faker));
                $this->faker->addProvider(new enPhoneNumber($this->faker));
                break;
        }
    }

    public function createErrors(string $str, float|int $countErrors): string
    {

        if(is_float($countErrors)) {
            $countErrors = $this->possibilityOfError($countErrors);
        }
        if (!$countErrors) {
            return $str;
        }
        for ($i = 0; $i < $countErrors; ++$i) {
            $errorType = random_int(1, 3);
            switch ($errorType) {
                case 1:
                    $str = $this->removeRandomChar($str);
                    break;
                case 2:
                    $str = $this->addRandomChar($str);
                    break;
                case 3:
                    $str = $this->swapRandomAdjacentChars($str);
                    break;
            }
        }
        return $str;
    }

    public function introduceErrors(array $array, int|float $errors): array
    {
        //     $uuid= $array['uuid'];
        //  $array['uuid'] = '';
        $string = implode(';', $array);
        $errorString = $this->createErrors($string, $errors);
        $newArray = explode(';', $errorString);
        $newArray = array_combine(array_keys($array), $newArray);
        //     $newArray['uuid'] = $uuid;

        return $newArray;
    }

    public function removeRandomChar(string $str): string
    {
        $strArray = mb_str_split($str);
        $alphabetChars = [];
        foreach ($strArray as $key => $char) {
            if (preg_match('/\pL/u', $char)) {
                $alphabetChars[$key] = $char;
            }
        }
        if (empty($alphabetChars)) {
            return $str;
        }
        $keys = array_keys($alphabetChars);
        $pos = $keys[random_int(0, count($keys) - 1)];
        return mb_substr($str, 0, $pos) . mb_substr($str, $pos + 1);
    }

    public function addRandomChar(string $str): string
    {
        $strArray = mb_str_split($str);
        $alphabetChars = [];
        foreach ($strArray as $key => $char) {
            if (preg_match('/\pL/u', $char)) {
                $alphabetChars[$key] = $char;
            }
        }
        if (empty($alphabetChars)) {
            return $str;
        }
        $pos = random_int(0, mb_strlen($str));
        $charKeys = array_keys($alphabetChars);
        $char = $alphabetChars[$charKeys[random_int(0, count($charKeys) - 1)]];
        return mb_substr($str, 0, $pos) . $char . mb_substr($str, $pos);

    }

    public function swapRandomAdjacentChars(string $str): string
    {
        $strArray = mb_str_split($str);
        if (count($strArray) < 2) {
            return $str;
        }
        $pos = random_int(0, count($strArray) - 2);
        $temp = $strArray[$pos];
        $strArray[$pos] = $strArray[$pos + 1];
        $strArray[$pos + 1] = $temp;
        return implode('', $strArray);
    }

    public function possibilityOfError($error): int
    {
        $chance = random_int(1, 2);
        if ($chance === 1) {
            $error =  floor($error);
        }
        if ($chance === 2) {
            $error = ceil($error);
        }
        return $error;
    }
}