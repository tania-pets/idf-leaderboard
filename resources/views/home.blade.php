<?php
/**
 * @var \App\User $user
 * @var \App\CourseEnrollment[]|\Illuminate\Database\Eloquent\Collection $myEnrollments
 */
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="card-header">My courses</h2>
                    <div class="card-body">
                        <ul>
                        @foreach($myEnrollments as $myEnrollment)
                            <li>
                                <a href="{{ route('courseEnrollments.show', [$myEnrollment->course->slug]) }}">
                                    {{ $myEnrollment->course->title }}
                                </a>
                            </li>
                        @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
