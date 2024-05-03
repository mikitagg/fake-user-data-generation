<?php

namespace App\Service;
use Faker;
use Faker\Factory;

class PhoneNumberGenerator
{
    protected Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
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
        $c = $this->faker->numberBetween(1, 4);
        return match ($c) {
            1 => '+ 7 (9##) ###-####',
            2 => '8-4##-###-####',
            3 => '8-8##-###-####',
            4 => '(352##)##-###',
            default => '',
        };
    }

    public function enNumber(): string
    {
        $c = $this->faker->numberBetween(1, 3);
        return match ($c) {
            1 => '00-1-###-#######',
            2 => '(###) ###-####',
            3 => '+1 (###) ###-####',
            default => '',
        };
    }

    public function frNumber(): string
    {
        $c = $this->faker->numberBetween(1, 3);
        return match ($c) {
            1 => '+ (33 #) ## ## ## ##',
            2 => '+ 33-###-####-### ',
            3 => '01 ## ## ## ##',
            default => '',
        };
    }
}