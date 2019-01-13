<?php declare(strict_types=1);

namespace App\LeaderBoard;

/**
 * Interface for possible leaderboard storages
 *
 */

use App\{User, Course};

interface LeaderBoardStorageInterface
{
    public function setUser(User $user): LeaderBoardStorageInterface;

    public function setCourse(Course $course): LeaderBoardStorageInterface;

    public function setType(string $type = null): LeaderBoardStorageInterface;

    public function getLeaders(bool $withScores = true) : array;

    public function getLoosers(bool $withScores = true) : array;

    public function getRank(int $userId): int;

    public function storeScore($score): void;

    public function arroundMe(): array;

}
