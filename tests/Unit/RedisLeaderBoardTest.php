<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Traits\{UseRedis, UseDatabase};
use App\LeaderBoard\{RedisLeaderBoard, LeaderBoardEngine};
use App\{User, Course};
use Redis;

class RedisLeaderBoardTest extends TestCase
{
    use UseRedis, UseDatabase;

    /**
     * @covers RedisLeaderBoard@getLeaders
     */
    public function testGetLeaders()
    {
        $user = factory(User::class)->create(['country_id' => $this->getRandomCountryId()]);
        $course = factory(Course::class)->create();
        $redisLb = (new RedisLeaderBoard())->setCourse($course)->setUser($user)->setType('global');

        $usersScoresPushed = [];
        $scores = [2, 3, 5, 10, 11, 20, 30, 4, 2, 9];
        for($i=1 ; $i<10 ; $i++) {
            $user = factory(User::class)->create(['country_id' => $this->getRandomCountryId()]);
            $usersScoresPushed[$user->id] = $scores[$i];
            $redisLb->setUser($user);
            $redisLb->storeScore($scores[$i]);
        }

        $expectedLeads = []; //push  the leaders_shown count max scores with assign user ids in expectedLeads table
        for ($i = 0; $i<LeaderBoardEngine::getConf('leaders_shown') ; $i++) {
            $score = max($scores);
            $userId = array_search($score, $usersScoresPushed);
            $expectedLeads[$userId] = $score;
            unset($scores[array_search($score, $scores)]);
        }
        $this->assertEquals($expectedLeads, $redisLb->getLeaders());
    }
}
