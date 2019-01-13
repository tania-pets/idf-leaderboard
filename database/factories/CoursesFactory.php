<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Course::class, function (Faker $faker) {
    $words = [
        'Design',
        'Thinking',
        'UX',
        'UI',
        'User Experience',
        'How to',
        'Product',
        'Web Deisign',
        'Visualization',
        'Management',
        'for',
        'and',
        'or',
        'with',
        'from scratch',
    ];
    $title = collect($words)->shuffle()->take(random_int(3, 7))->implode(' ');

    return [
        'title' => $title,
        'slug' => str_slug($title),
    ];
});

$factory->define(\App\Lesson::class, function (Faker $faker) {
    return [
//        'course_id',
        'title' => $faker->sentence,
        'number' => $faker->numberBetween(1, 100),
    ];
});

$factory->define(App\CourseEnrollment::class, function (Faker $faker) {
    return [
        'course_id' => function () {
            return factory(\App\Course::class)->lazy()->getKey();
        },
        'user_id' => function () {
            return factory(\App\User::class)->lazy()->getKey();
        },
    ];
});

$factory->define(\App\Quiz::class, function (Faker $faker) {
    return [
//        'lesson_id',
        'max_score' => random_int(5, 10),
        'question' => sprintf('Is %s similar to %s?', $this->faker->colorName, $this->faker->colorName),
    ];
});

$factory->define(App\QuizAnswer::class, function (Faker $faker) {
    return [
//        'quiz_id',
//        'user_id',
        'answer' => $faker->sentence,
        'score' => random_int(0, 5),
    ];
});
