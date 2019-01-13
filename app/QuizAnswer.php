<?php declare(strict_types=1);

namespace App;
use App\Events\{QuizAnswerEvaluating,QuizAnswerEvaluated};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $quiz_id
 * @property int $user_id
 * @property string $answer
 * @property string $score
 *
 * @property Quiz $quiz
 */
final class QuizAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
        'answer',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function evaluate(int $score, GraderInterface $gradedBy): void
    {
        $maxScore = $this->quiz->max_score;
        if ($score > $this->quiz->max_score) {
            throw new \OutOfBoundsException("Score can not be higher that maximum for this quiz (max={$maxScore})");
        }

        event(new QuizAnswerEvaluating($this, $score, $gradedBy));

        $this->score = $score;
        $this->save();

        event(new QuizAnswerEvaluated($this, $score, $gradedBy));
    }

    /**
     * Scope for quiz
     */
    public function scopeOnQuiz(\Illuminate\Database\Eloquent\Builder $query, int $quizId)
    {
        $query->where('quiz_id', $quizId);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
