<?php declare(strict_types=1);

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\{QuizAnswer,GraderInterface};

final class QuizAnswerEvaluating
{
    use SerializesModels;

    /** @var QuizAnswer */
    private $quizAnswer;

    /** @var int */
    private $score;

    /** @var GraderInterface */
    private $grader;

    public function __construct(QuizAnswer $quizAnswer, int $score, GraderInterface $grader)
    {
        $this->quizAnswer = $quizAnswer;
        $this->score = $score;
        $this->grader = $grader;
    }
}
