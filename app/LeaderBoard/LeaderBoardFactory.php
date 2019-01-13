<?php declare(strict_types=1);

namespace App\LeaderBoard;
use App\{User, Course};
use Config;

Class LeaderBoardFactory
{

    public static function makeLeaderBoard(User $user, Course $course, string $type = null): LeaderBoardEngine
    {
        //get leaderboard storage engine from config
        $lbStorage = LeaderBoardEngine::getConf('default');
        if($lbStorage == 'redis') {
            $leaderBoardStorage = new RedisLeaderBoard();
        } else {
            throw new \Exception('Not implemented');
        }
        return new LeaderBoardEngine($leaderBoardStorage, $user, $course, $type);
    }

}
