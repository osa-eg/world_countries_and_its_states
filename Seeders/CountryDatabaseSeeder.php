<?php

namespace Modules\Country\Database\Seeders;

use File;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PragmaRX\Countries\Package\Countries;

class CountryDatabaseSeeder extends Seeder
{
    public $data = [];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->updateFilesData();
    }

    public function storeDataFromFiles()
    {
        $continents_source              = realpath(__DIR__ . '/data/continents.json');
        $continents_translations_source = realpath(__DIR__ . '/data/continent_translations.json');
        $countries_source               = realpath(__DIR__ . '/data/countries.json');
        $country_translations_source    = realpath(__DIR__ . '/data/country_translations.json');
        $states_source                  = realpath(__DIR__ . '/data/states.json');
        $state_translations_source      = realpath(__DIR__ . '/data/state_translations.json');

        $continents              = json_decode(file_get_contents($continents_source), true);
        $continents_translations = json_decode(file_get_contents($continents_translations_source), true);
        $countries               = json_decode(file_get_contents($countries_source), true);
        $country_translations    = json_decode(file_get_contents($country_translations_source), true);
        $states                  = json_decode(file_get_contents($states_source), true);
        $state_translations      = json_decode(file_get_contents($state_translations_source), true);

        $this->command->info('Start delete all tables');
        DB::table('continents')->delete();
        DB::table('continents_translations')->delete();
        DB::table('countries')->delete();
        DB::table('country_translations')->delete();
        DB::table('states')->delete();
        DB::table('state_translations')->delete();
        $this->command->info('==================== all tables have deleted ==================');

        DB::table('continents')->insert($continents);
        $this->command->info('==================== continents is saved ==================');

        DB::table('continents_translations')->insert($continents_translations);
        $this->command->info('==================== continents_translations is saved ==================');

        foreach (collect($countries)->chunk(100) as $key => $list) {
            DB::table('countries')->insert($list->toArray());
        }
        $this->command->info('==================== countries is saved ==================');

        foreach (collect($country_translations)->chunk(100) as $key => $list) {
            DB::table('country_translations')->insert($list->toArray());
        }
        $this->command->info('==================== country_translations is saved ==================');

        foreach (collect($states)->chunk(100) as $key => $list) {
            DB::table('states')->insert($list->toArray());
        }
        $this->command->info('==================== states is saved ==================');

        foreach (collect($state_translations)->chunk(100) as $key => $list) {
            DB::table('state_translations')->insert($list->toArray());
        }
        $this->command->info('==================== state_translations is saved ==================');
    }


    public function updateFilesData()
    {
        $continents             = DB::table('continents')->get()->toArray();
        $continent_translations = DB::table('continents_translations')->get()->toArray();
        $countries              = DB::table('countries')->get()->toArray();
        $country_translations   = DB::table('country_translations')->get()->toArray();
        $states                 = DB::table('states')->get()->toArray();
        $state_translations     = DB::table('state_translations')->get()->toArray();

        File::put(__DIR__ . '/data/continents.json', json_encode($continents));
        File::put(__DIR__ . '/data/continent_translations.json', json_encode($continent_translations));
        File::put(__DIR__ . '/data/countries.json', json_encode($countries));
        File::put(__DIR__ . '/data/country_translations.json', json_encode($country_translations));
        File::put(__DIR__ . '/data/states.json', json_encode($states));
        File::put(__DIR__ . '/data/state_translations.json', json_encode($state_translations));
    }
}