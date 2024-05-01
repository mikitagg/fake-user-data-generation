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

    public function generateData(?string $region = 'RU'): array
    {
        $userData = [];

        $this->setRegion($region);

        for ($i = 0; $i < 10; ++$i) {
            $userData[] = [
                'id' => $i,
                'uuid' =>  $this->faker->unique()->uuid(),
                'name' => $this->faker->name(),
                'address' => $this->faker->address(),
                'phoneNumber' =>  $this->faker->phoneNumber(),
            ];
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

}