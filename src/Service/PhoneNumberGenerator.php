<?php

namespace App\Service;
use Faker;
use Faker\Factory;

class PhoneNumberGenerator
{
    protected \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function countryPhoneNumber(string $region): string
    {
        return match ($region) {
            'FR' => $this->frNumber(),
            'EN' => $this->enNumber(),
            'RU' => $this->ruNumber(),
            default => '',
        };
    }

    public function ruNumber(): string
    {
        $c = random_int(1, 4);
        return match ($c) {
            1 => $this->faker->numerify('+ 7 (9##) ###-####'),
            2 => $this->faker->numerify('8-4##-###-####'),
            3 => $this->faker->numerify('8-8##-###-####'),
            4 => $this->faker->numerify('(352##)##-###'),
            default => '',
        };
    }

    public function enNumber(): string
    {
        $c = random_int(1, 3);
        return match ($c) {
            1 => $this->faker->numerify('00-1-###-#######'),
            2 => $this->faker->numerify('(###) ###-####'),
            3 => $this->faker->numerify('+1 (###) ###-####'),
            default => '',
        };
    }

    public function frNumber(): string
    {
        $c = random_int(1, 3);
        return match ($c) {
            1 => $this->faker->numerify('+ (33 #) ## ## ## ##'),
            2 => $this->faker->numerify('+ 33-###-####-### '),
            3 => $this->faker->numerify('01 ## ## ## ##'),
            default => '',
        };
    }
}