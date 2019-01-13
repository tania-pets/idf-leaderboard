<?php
/**
 * Unit tests use different database from dev enviroment (phpunit.xml)
 * The database gets flushed before every new test.
 * Trait used to clear
 */
namespace Tests\Traits;

use Redis;

Trait UseRedis
{

    public function flushDb() : void
    {
        Redis::flushdb();
    }

}
