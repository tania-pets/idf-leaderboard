<?php

use App\CourseEnrollment;
use App\Quiz;
use App\QuizAnswer;
use App\User;
use Illuminate\Database\Seeder;

class QuizAnswersSeeder extends Seeder
{
    private const NUMBER_OF_USERS = 200;

    /** @var \Illuminate\Support\Collection */
    private $countryIds;
    /** @var \Illuminate\Support\Collection */
    private $courseIds;

    public function __construct()
    {
        $this->countryIds = \App\Country::all(['id'])->pluck('id');
        $this->courseIds = \App\Course::all(['id'])->pluck('id');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < self::NUMBER_OF_USERS; $i++) {
            $user = factory(User::class)->create(['country_id' => $this->countryIds->random()]);
            $this->enrolInCoursesAndGenerateAnswers($user, random_int(0, $this->courseIds->count()));
        }
    }

    private function enrolInCoursesAndGenerateAnswers(User $user, int $numberOfCoursesToEnrol)
    {
        $userEnroledTo = [];

        for ($i = 0; $i < $numberOfCoursesToEnrol; $i++) {
            $courseIdToEnrol = $this->courseIds->diff($userEnroledTo)->random();
            $userEnroledTo[] = $courseIdToEnrol;
            $enrolment = factory(CourseEnrollment::class)->create([
                'user_id' => $user->id,
                'course_id' => $courseIdToEnrol,
            ]);

            $this->generateAnswersForEnrolment($enrolment);
        }
    }

    private function generateAnswersForEnrolment(CourseEnrollment $enrollment)
    {
        $allQuizesFromCourse = $enrollment->course->quizzes;
        $quizzesToGenerateAnswers = $allQuizesFromCourse->take(random_int(0, $allQuizesFromCourse->count()));

        $quizzesToGenerateAnswers->each(function (Quiz $quiz) use ($enrollment) {
            factory(QuizAnswer::class)->create([
                'quiz_id' => $quiz->id,
                'user_id' => $enrollment->user->id,
                'score' => random_int(0, $quiz->max_score),
            ]);
        });
    }
}
