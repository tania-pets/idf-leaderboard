<?php
/**
 * Job to update the user's total score for a course in redis and db
 * It's published every time a question evaluation happens
 */
namespace App\Jobs;

use App\{Course, User};
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        // @todo
        // Log::info('consume' . $this->course->id . ' ppp ' . $this->user->id);
    }


}
