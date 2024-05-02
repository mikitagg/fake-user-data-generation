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

    public function generateData(?string $region, ?int $errors, int|string|null $seed ): array
    {
        $this->faker->seed($seed);
        $userData = [];
        $this->setRegion($region);

        for ($i = 0; $i < 100; ++$i) {
            $userData[] = $this->introduceErrors([
                'id' => $i,
                'uuid' =>  $this->faker->unique()->uuid(),
                'name' => $this->faker->name(),
                'address' => $this->faker->address(),
                'phoneNumber' =>  $this->faker->phoneNumber(),
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

    public function createErrors(string $str, ?int $countErrors): string
    {
        if (!$countErrors) {
            return $str;
        }
        for ($i = 0; $i < $countErrors; ++$i) {
            $typeError = rand(1, 3);
            switch ($typeError) {
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

    public function introduceErrors(array $array, ?int $errors): array
    {
        $uuid= $array['uuid'];
        $array['uuid'] = '';
        $string = implode(';', $array);
        $errorString = $this->createErrors($string, $errors);
        $newArray = explode(';', $errorString);
        $newArray = array_combine(array_keys($array), $newArray);
        $newArray['uuid'] = $uuid;

        return $newArray;
    }

    function removeRandomChar(string $str): string
    {
        $strArray = str_split($str);
        $alphabetChars = array_filter($strArray, function($char) {
            return preg_match('/\pL/u', $char);
        });
        if (empty($alphabetChars)) {
            return $str;
        }
        $pos = array_rand($alphabetChars);
        return substr_replace($str, '', $pos, 1);
    }

    function addRandomChar(string $str): string
    {
        $strArray = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
        $alphabetChars = array_filter($strArray, function($char) {
            return preg_match('/\pL/u', $char);
        });
        if (empty($alphabetChars)) {
            return $str;
        }
        $pos = rand(0, mb_strlen($str));
        $char = $alphabetChars[array_rand($alphabetChars)];
        return mb_substr($str, 0, $pos) . $char . mb_substr($str, $pos);
    }

    function swapRandomAdjacentChars(string $str): string
    {
        $strArray = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
        if (count($strArray) < 2) {
            return $str;
        }
        $pos = rand(0, count($strArray) - 2);
        list($strArray[$pos], $strArray[$pos+1]) = array($strArray[$pos+1], $strArray[$pos]);
        return implode('', $strArray);
    }

}