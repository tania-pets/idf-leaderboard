<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\UseDatabase;
use App\{Course, Lesson, Quiz, User, Country, CourseEnrollment, QuizAnswer};


class CourseEnrollmentTest extends TestCase
{
    use UseDatabase;

    /**
     * @covers App\CourseEnrollment@calculateScore
     */
    public function testCalculateScore() : void
    {
         //add user
         $user = factory(User::class)->create(['country_id' => $this->getRandomCountryId()]);
         //add course
         $course = factory(Course::class)->create();

         //enroll user to course
         $enrollment = factory(CourseEnrollment::class)->create([
             'user_id' => $user->id,
             'course_id' => $course->id,
         ]);

         //add lesson to course
         $lesson = factory(Lesson::class)->create([
             'course_id' => $course->getKey(),
             'number' => 1,
         ]);

         //add quizzes to lesson
         $maxScores = [8, 9, 10, 12, 6, 7, 20];
         $scoresAchieved = [8, 7, 3, 2, 0, 6, 10];
         for ($i = 0; $i <= 6; $i++) {
            //add quiz
            $quiz = factory(Quiz::class)->create([
                 'lesson_id' => $lesson->getKey(),
                 'max_score' => $maxScores[$i],
             ]);
             //add answer
             $answer = factory(QuizAnswer::class)->create([
                 'quiz_id' => $quiz->id,
                 'user_id' => $enrollment->user->id,
                 'score' => $scoresAchieved[$i]
             ]);
         }

         //compare scores
         $scoreExcpected = array_sum($scoresAchieved);
         $this->assertEquals($enrollment->calculateScore(), $scoreExcpected);


         //decrease the score of an answers and recalculate
         $answerToRevaluate = $user->quizAnswers()->onQuiz($quiz->id)->first();
         $answerToRevaluate->score--;
         $answerToRevaluate->save();

         $this->assertEquals($enrollment->calculateScore(), $scoreExcpected - 1);

         //delete answers and recalculate
         $user->quizAnswers()->delete();
         $this->assertEquals($enrollment->calculateScore(), 0);

    }


    private function getRandomCountryId(): int
    {
        return Country::all(['id'])->pluck('id')->random();
    }
}
