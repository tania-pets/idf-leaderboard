<?php declare(strict_types=1);

namespace App\LeaderBoard;


/**
 * Class that utilizes LeaderBoardStorageInterface $lb_storage to fetch and store the leaderboard data
 */

use App\{User, Course};
Class LeaderBoardEngine
{
    private $lb_storage;

    const LEADERBOARD_TYPES = [  'country', 'global'];
    /**
     * For flexibility purpose, the class accepts LeaderBoardStorageInterface object
     * Right now it's on redis but it can easily be implemented with different storage
     * @param LeaderBoardStorageInterface $lb_storage the storage class
     * @param User $user the user to be either ranked or see the leaderboard
     * @param Course $course, the course to be either ranked or viewed on webpage
     * @param string $type - optional- define the type of leaderboard (global|country)
     */
    public function __construct(LeaderBoardStorageInterface $lb_storage, User $user, Course $course, string $type = null)
    {
        $this->lb_storage = $lb_storage->setUser($user)->setCourse($course)->setType($type);
    }


    /**
     * Construct the list of the leaderboard
     *
     */
    public function getLeaderBoardList()
    {
        $leaders = $this->formatUsers($this->lb_storage->getLeaders());
        $loosers = $this->formatUsers($this->lb_storage->getLoosers());
        $arroundMe = $this->formatUsers($this->lb_storage->arroundMe());
        $users = array_merge($leaders, $loosers, $arroundMe);
        usort($users, function($el1, $el2){
            return $el1['score'] < $el2['score'];
        });
        $users = collect($users);
        return $users->keyBy('user_id')->toArray();
    }


    /**
     * Sets the score for given user
     * @param in $score
     */
    public function storeScore(int $score): void
    {
        $this->lb_storage->storeScore($score);
    }

    /**
     * Get's values  from leaderboard configuration
     * @param string $key
     */
    public static function getConf(string $key)
    {
        return Config('leaderboard.' . $key);
    }

    /**
     * Add ordinal suffix to rank
     * https://en.wikipedia.org/wiki/English_numerals#Ordinal_numbers
     * @paran int $rank
     * @return string
     */
    public static function withOrdinalSuffix(int $rank) : string
    {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if (($rank %100) >= 11 && ($rank%100) <= 13) {
            $abbreviation = $rank. 'th';
        }
        else {
            $abbreviation = $rank. $ends[$rank % 10];
        }
        return $abbreviation;
    }


    /**
     * Formats the data for the lists
     * @param array $users
     */
    private function formatUsers(array $users) : array
    {
        $data = [];
        $i = 0;
        foreach($users as $userId => $score) {
            $rank = $this->lb_storage->getRank($userId);
            //fix ranks after swapping (equals case)
            if (isset($prevItem) && ($prevItem['score'] == $score)) {
                if ($prevItem['rank'] > $rank) {
                    $key = array_search($prevItem['user_id'], array_column($data, 'user_id'));
                    $data[$key]['rank']--;
                }
            }        
            $item = ['user_id' => $userId, 'score' => $score, 'rank' => $rank + 1 ];
            $data[] = $item;
            $prevItem = $item;
        }
        return $data;
    }
}
