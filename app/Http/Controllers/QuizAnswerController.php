<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Quiz;
use App\QuizAnswer;
use Illuminate\Http\RedirectResponse;

class QuizAnswerController extends Controller
{
    public function store(int $id): RedirectResponse
    {
        $this->validate(request(), [
            'answer' => ['required'],
        ]);

        /** @var Quiz $quiz */
        $quiz = Quiz::query()->with('lesson.course')->find($id) ?? abort('Quiz not found');

        QuizAnswer::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'answer' => request('answer'),
        ]);

        return redirect(route('lessons.show', [
            'slug' => $quiz->lesson->course->slug,
            'number' => $quiz->lesson->number,
        ]));
    }
}
