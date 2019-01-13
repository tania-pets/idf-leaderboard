<?php

use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $course = factory(\App\Course::class)->create();
            $this->addLessonsToCourse($course);
        }
    }

    private function addLessonsToCourse(\App\Course $course)
    {
        $numberOfLessons = random_int(8, 15);

        for ($i = 0; $i < $numberOfLessons; $i++) {
            $lesson = factory(\App\Lesson::class)->create([
                'course_id' => $course->getKey(),
                'number' => $i + 1,
            ]);
            $this->addQuizzesToLesson($lesson);
        }
    }

    private function addQuizzesToLesson(\App\Lesson $lesson)
    {
        $numberOfQuizzes = random_int(1, 5);

        for ($i = 0; $i < $numberOfQuizzes; $i++) {
            factory(\App\Quiz::class)->create([
                'lesson_id' => $lesson->getKey(),
                'max_score' => random_int(5, 10),
            ]);
        }
    }
}
