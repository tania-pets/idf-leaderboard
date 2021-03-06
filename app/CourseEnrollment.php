<?php declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\LeaderBoard\{LeaderBoardFactory, LeaderBoardEngine};
/**
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property int $score

 *
 * @property Course $course
 * @property User $user
 */
final class CourseEnrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'score'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfUser(\Illuminate\Database\Eloquent\Builder $query, \App\User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeOnCourse(\Illuminate\Database\Eloquent\Builder $query, \App\Course $course)
    {
        return $query->where('course_id', $course->id);
    }
    /**
     * Calculates the score that user has achieved in this enrollment's course quizzes in total
     * @return    int
     */
    public function calculateScore(): int
    {
        $answersGiven = QuizAnswer::where('user_id', $this->user_id)->whereHas('quiz', function($q) {
            $q->whereHas('lesson', function($l) {
                $l->where('course_id', $this->course_id);
            });
        })->get();
        return $answersGiven->count() ? $answersGiven->sum('score') : 0;
    }

    /**
     * Calculates the score of a user for this enrollment's course and stores to leaderboard storage
     */
    public function storeUserScoreToLeaderBoard(): void
    {
        $score = $this->calculateScore();
        $leaderBoardTypes = LeaderBoardEngine::LEADERBOARD_TYPES; //country, global
        //update sorted sets both global and country
        foreach ($leaderBoardTypes as $lbType) {
            $leaderBoard = LeaderBoardFactory::makeLeaderBoard($this->user, $this->course, $lbType);
            $leaderBoard->storeScore($score);
        }
        //save score in db for backup - not used
        $this->score = $score;
        $this->save();
    }
}
