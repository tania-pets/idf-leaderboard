<?php
/**
 * Trait used to create a fresh db on every test and seed any given seeders
 */
namespace Tests\Traits;


Trait UseDatabase
{

    public function createDatabase(bool $fresh = true, array $seeders = []) : void
    {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
        //run the seeders
        foreach ($seeders as $seederClass) {
            $seeder = new $seederClass();
            $seeder->run();
        }
    }

    /**
     * Used often to create users
     */
    public function getRandomCountryId(): int
    {
        return \App\Country::all(['id'])->pluck('id')->random();
    }
}
