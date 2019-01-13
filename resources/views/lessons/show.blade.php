<?php
/**
 * @var \App\Lesson $lesson
 * @var \App\Course $course
 */
?>
@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>{{ $course->title }}</h1>

        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h2 class="card-header">Lessons</h2>
                    <ul>
                    @foreach($course->lessons as $lessonInCourse)
                        <li>
                            <a href="{{ route('lessons.show', ['slug' => $course->slug, 'number' => $lessonInCourse->number]) }}">
                                {{ $lessonInCourse->number }}. {{ $lessonInCourse->title }}
                            </a>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <h2 class="card-header">Lesson #{{ $lesson->number }}: {{ $lesson->title }}</h2>
                    <div class="card-body">
                        <ol>
                            @foreach($lesson->quizes as $quiz)
                                <li>
                                    <div>
                                        <p>{{ $quiz->question }}</p>

                                        <div>
                                            <form action="{{ route('quizAnswers.store', [$quiz->id]) }}" method="POST">
                                                <?php $answer = $quiz->getAnswerOf(auth()->user()); ?>
                                                <fieldset {{ $answer ? 'disabled' : '' }}>
                                                    @csrf
                                                    <textarea
                                                        name="answer"
                                                        id=""
                                                        cols="30"
                                                        rows="10"
                                                        class="form-control"
                                                        required
                                                        minlength="2">{{ optional($answer)->answer }}</textarea>

                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </fieldset>

                                            </form>
                                        </div>
                                    </div>
                                </li>
                                <hr>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
