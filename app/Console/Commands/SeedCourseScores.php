<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use App\CourseEnrollment;

class SeedCourseScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaderboard:seedcoursescores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed redis (and db for backup) with user\'s scores per course';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('max_execution_time', '120');
        $enrollments = CourseEnrollment::all();
        $bar = $this->output->createProgressBar(count($enrollments));

        foreach ($enrollments as $enrollment) {
            $enrollment->storeUserScoreToLeaderBoard();
            $bar->advance();
        }
        $bar->finish();
    }
}
