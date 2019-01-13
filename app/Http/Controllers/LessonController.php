<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Course;
use App\Lesson;
use Illuminate\Http\Response;

class LessonController extends Controller
{
    public function show(string $slug, int $number)
    {
        /** @var Course $course */
        $course = Course::query()
                ->where('slug', $slug)
                ->first() ?? abort(Response::HTTP_NOT_FOUND, 'Course not found');

        $lesson = Lesson::query()
            ->with('quizes')
            ->where('number', $number)
            ->first() ?? abort(Response::HTTP_NOT_FOUND, 'Lesson not found');

        return view('lessons.show', [
            'course' => $course,
            'lesson' => $lesson,
        ]);
    }
}
