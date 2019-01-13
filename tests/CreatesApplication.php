<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Tests\Traits\{UseDatabase, UseRedis};
trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        //check for traits and execute what's needed
        $uses = array_flip(class_uses_recursive(static::class));
        //create the test database with countries seeded
        if (isset($uses[UseDatabase::class])) {
            $this->createDatabase(true, ['\CountriesSeeder']);
        }
        if (isset($uses[UseRedis::class])) {
            $this->beforeApplicationDestroyed(function () {
                $this->flushDb();
            });
        }

        return $app;
    }
}
