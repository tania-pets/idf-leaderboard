<?php
/**
 * QuizAnswerEvaluatedEvent event listener
 * It will add a job for recalculating user's course score and push it to redis and db
 */

namespace App\Listeners;

use App\Events\QuizAnswerEvaluated as QuizAnswerEvaluatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\UpdateCourseScoreForUser;
use Log;

Class QuizAnswerEvaluated implements ShouldQueue
{

 /**
  * Handle the event.
  * @param  \App\Events\QuizAnswerEvaluatedEvent  $event
  * @return void
  */
 public function handle(QuizAnswerEvaluatedEvent $event)
 {
     $quizAnswer = $event->getQuizAnswer();
     $course = $quizAnswer->quiz->lesson->course;

     Log::info('CCC ' .$quizAnswer->quiz->lesson->course->id);

     dispatch(new UpdateCourseScoreForUser($course, $quizAnswer->user));
 }


 public function failed(QuizAnswerEvaluatedEvent $event, \Exception $exception)
 {
     Log::error("QuizAnswerEvaluated listener failed to execute " . $exception->getMessage());
 }



}
