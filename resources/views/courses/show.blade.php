<?php
/**
 * @var \App\Course $course
 */
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="card-header">Lessons</h2>
                    <div class="card-body">
                        <ol>
                            @foreach($course->lessons as $lesson)
                                <li>{{ $lesson->title }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    @auth()
                        <form action="{{ route('courseEnrollments.store', [$course->slug]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Enroll</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Join to enroll</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
