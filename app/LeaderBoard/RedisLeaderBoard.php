<?php declare(strict_types=1);

namespace App\LeaderBoard;

/**
 * Redis storage Class for leaderboard
 * Uses redis sorted sets https://redis.io/topics/data-types
 * Uses redis php client phpredis https://github.com/phpredis/phpredis
 */

use Redis;
use App\{User, Course};

final class RedisLeaderBoard implements LeaderBoardStorageInterface
{

    private $redis; //PredisConnection connection
    private $set; //string - redis sorted set key name
    private $user; // User, user to be scored
    private $course; //Course, the course to be scored

    const SET_NAME_PLACEHOLDERS = ['##COURSE_ID##', '##COUNTRY_ID##'];

    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    /**
     * Returns a list with the leaders (count taken from conf)
     * @param bollean $withScores if we need the scores alogn with the user ids
     * @return    array
     */
    public function getLeaders(bool $withScores = true): array
    {
        return $this->redis->zRevRange($this->set, 0, LeaderBoardEngine::getConf('leaders_shown') -1, ['WITHSCORES' => $withScores]);
    }

    /**
     * Returns a list with the loosers (count taken from conf)
     * @param bollean $withScores if we need the scores alogn with the user ids
     * @return    array
     */
    public function getLoosers(bool $withScores = true): array
    {
        return $this->redis->zRevRange($this->set, (-1 * LeaderBoardEngine::getConf('loosers_shown')), -1, ['WITHSCORES' => $withScores]);
    }

    /**
     * Returns the rank for given user
     * @return    int
     */
    public function getRank(int $userId): int
    {
        return $this->redis->zRevRank($this->set, $userId);
    }

    /**
     * Sets the score for the user
     * @param int $score
     * @return    void
     */
    public function storeScore($score): void
    {
        $this->redis->zAdd($this->set, $score, (string)$this->user->id);
    }

    /**
     * Returns an array containing the previous, myself and the next user with our scores
     */
    public function arroundMe(): array
    {
        return $this->arroundUser($this->user->id);
    }

    /**
     * Returns an array containing the previous user, the user with id $UserId and the next user with their scores
     * e.g ["john"=>3, "me"=>2, "peter"=> 1]
     * if user is first, the array will be empty
     * if the user is last, the array will contain 2 elements. The user and the previous one.
     */
    public function arroundUser(int $userId, bool $withScores = true): array
    {
        $rank = (int)$this->getRank($this->user->id);
        return $this->redis->zRevRange($this->set, $rank - LeaderBoardEngine::getConf('above_me_shown'), $rank + LeaderBoardEngine::getConf('below_me_shown'), ['WITHSCORES' => $withScores]);
    }

    public function setType(string $type = null): LeaderBoardStorageInterface
    {
        $this->setSet($type);
        return $this;
    }

    public function setCourse(Course $course): LeaderBoardStorageInterface
    {
        $this->course = $course;
        return $this;
    }

    public function setUser(User $user): LeaderBoardStorageInterface
    {
        $this->user = $user;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Sets the redis sorted set's name
     * @param string $type (global|country)
     */
    private function setSet($type): void
    {
        $this->set = $this->getSetName($type);
    }
    /**
     * Get list names from config depend on the provided type
     * replace placeholders and return the set's name
     * @param string $type (global|country)
     */
    private function getSetName(string $type): string
    {
        $lists = LeaderBoardEngine::getConf('storage.redis.sets');
        $listPattern = $lists[$type]['prefix'] ?? null;
        if ($listPattern == null) {
            throw new Exception('Wrong config or leadboard type provided.');
        }
        foreach (self::SET_NAME_PLACEHOLDERS as $placeHolder) {
            switch($placeHolder) {
                case '##COURSE_ID##':
                    $replace = $this->course->id;
                    break;
                case '##COUNTRY_ID##':
                    $replace = $this->user->country_id;
                    break;
                }
                $listPattern = preg_replace("/$placeHolder/", $replace, $listPattern);
            }
            return $listPattern;
    }
}
