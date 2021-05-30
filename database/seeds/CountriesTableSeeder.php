<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            'Afghanistan' => 'AF',
            'Albania' => 'AL',
            'Algeria' => 'DZ',
            'Andorra' => 'AD',
            'American Samoa' => 'AS',
            'Vietnamese' => 'VI',
            'Austrailia' => 'AU',
            'Autria' => 'AT',
            'Yemen' => 'YE',
            'Zimbabwe' => 'ZW',
            'Aland Islands' => 'AX'
        ];

        collect($countries)->each(function ($code, $name) {
            Country::create([
                'name' => $name,
                'code' => $code
            ]);
        });
    }
}
