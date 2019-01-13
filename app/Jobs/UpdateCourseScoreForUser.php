<?php
/**
 * Job to update the user's total score for a course in redis and db
 * It's published every time a question evaluation happens
 */
namespace App\Jobs;

use App\{Course, User, CourseEnrollment};
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\LeaderBoard\{LeaderBoardFactory, LeaderBoardEngine};
use Log;

class UpdateCourseScoreForUser implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $course;
    private $user;

    public function __construct(Course $course, User $user)
    {
       $this->course = $course;
       $this->user = $user;
    }

    public function handle()
    {
        //find the enrollment and calculate the updated score
        $courseEnrollment = CourseEnrollment::ofUser($this->user)->onCourse($this->course)->first();
        if (!$courseEnrollment) {
            Log::error('User is not enrolled');
            return;
        }
        $score = $courseEnrollment->calculateScore();
        $leaderBoardTypes = LeaderBoardEngine::LEADERBOARD_TYPES; //country, global
        //update sorted sets both global and country
        foreach ($leaderBoardTypes as $lbType) {
            $leaderBoard = LeaderBoardFactory::makeLeaderBoard($this->user, $this->course, $lbType);
            $leaderBoard->storeScore($score);
        }
        //save score in db for backup - not used
        $courseEnrollment->score = $score;
        $courseEnrollment->save();
    }


}
