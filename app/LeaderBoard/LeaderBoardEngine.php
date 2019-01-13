<?php declare(strict_types=1);

namespace App\LeaderBoard;


/**
 * Class that utilizes LeaderBoardStorageInterface $lb_storage to fetch and store the leaderboard data
 */

use App\{User, Course};

Class LeaderBoardEngine
{
    private $lb_storage;

    const LEADERBOARD_TYPES = ['country', 'global'];
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
    public function getLeaderBoardList(): array
    {
        $leaders = $this->lb_storage->getLeaders();
        $loosers = $this->lb_storage->getLoosers();
        $leadersAndLoosers = $leaders + $loosers;


        //i have both leaders and loosers in a list, let's see where am i
        $userId = $this->lb_storage->getUser()->id;
        $myPosition = array_search($userId, array_keys($leadersAndLoosers));

        //i i am in leaders or loosers first move me upper if any equal users
        if ($myPosition) {
            $myScore = $leadersAndLoosers[$userId];
            $this->moveMeUpperFromEquals($leadersAndLoosers, $myScore, $userId);
        }

        //if i am last of the leaders, or first of the loosers, or i am not a leader or a looser, then i need to fetch others arround me
        $lastOfLeadersPosition = self::getConf('leaders_shown') - 1;
        $firstOfLoossersPosition = self::getConf('leaders_shown');

        if (in_array($myPosition, [$lastOfLeadersPosition, $firstOfLoossersPosition, false])) {
            $arroundMe = $this->lb_storage->arroundMe();
            $leadersAndLoosers = $leaders + $arroundMe + $loosers;
        }

        //move me upper from equals
        $myScore = $leadersAndLoosers[$userId];
        $this->moveMeUpperFromEquals($leadersAndLoosers, $myScore, $userId);

        return $this->withRanks($leadersAndLoosers);
    }

    private function withRanks($leadersAndLoosers)
    {
        foreach ($leadersAndLoosers as $userId => $score)
        {
            $leadersAndLoosers[$userId] = ['score' => $score, 'rank' => $this->lb_storage->getRank($userId) + 1];
        }
        return $leadersAndLoosers;
    }

    /**
     * If same score with other users, i must be shown upper
     * @return    void
     */
    private function moveMeUpperFromEquals(array &$leadersAndLoosers, string $myScore, int $userId) : void
    {
        $moveMeUp = function($k1, $k2) use ($myScore, $leadersAndLoosers, $userId) {
            $score1 = $leadersAndLoosers[$k1];
            $score2 = $leadersAndLoosers[$k2];
            if ((($score2 == $score1) && ($score1 == $myScore)) && $k2==$userId) {
                return 1;
            }
        };
        uksort($leadersAndLoosers, $moveMeUp);
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


}
