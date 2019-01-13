<?php declare(strict_types=1);

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $lesson_id
 * @property string $question
 * @property int $max_score
 *
 * @property Lesson $lesson
 * @property Collection|QuizAnswer[] $answers
 */
final class Quiz extends Model
{
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function getAnswerOf(Authenticatable $user): ?QuizAnswer
    {
        return $this->answers()->where('user_id', $user->getAuthIdentifier())->first();
    }
}
