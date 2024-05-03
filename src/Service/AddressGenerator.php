<?php

namespace App\Service;

class AddressGenerator
{
    public array $formats = [
        '{buildingNumber} {streetName}, {city}, {postcode}, {country}',
        '{buildingNumber} {streetName}, {city}, {postcode}',
        '{country}, {city}, {buildingNumber} {streetName}',
        '{city}, {postcode}, {country}, {buildingNumber} {streetName}',
        '{buildingNumber} {streetName}, {postcode}, {country}',
    ];

    public array $addressVariable = ['{buildingNumber}', '{streetName}', '{city}', '{postcode}', '{country}'];

    public function setAddress($region): string
    {
        return match ($region)
        {
            'EN' => 'England',
            'FR' => 'France',
            'RU' => 'Россия'
        };
    }

    public function setPostCode(string $region): string
    {
        return match ($region)
        {
            'EN' => '??##??',
            'FR' => '#####',
            'RU' => '######'
        };
    }

}