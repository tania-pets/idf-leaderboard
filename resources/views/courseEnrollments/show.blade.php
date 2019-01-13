<?php
/**
 * @var \App\CourseEnrollment $enrollment
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
                            @foreach($enrollment->course->lessons as $lesson)
                                <li>
                                    <a href="{{ route('lessons.show', ['slug' => $enrollment->course->slug, 'number' => $lesson->number]) }}">
                                        {{ $lesson->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <div class="card mt-4">
                    <h2 class="card-header">Statistics</h2>
                    <div class="card-body">

                        <p>
                            Your rankings improve every time you answer a question correctly.
                            Keep learning and earning course points to become one of our top learners!
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>You are ranked <b>4th</b> in {{ auth()->user()->country->name }}</h4>
                                {{--Replace this stub markup by your code--}}
                                <ul style="padding: 0px;">
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            1
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Sandra Lidstream
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                205 PTS (+93)
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            2
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Corvin Dalek
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                200 PTS (+88)
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            3
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Kumar Jubar
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                180 PTS (+68)
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            4
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;"><b>Alfred Maroz</b></div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                112 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            5
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Arthur Rembo
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                95 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            15
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Colin Shpak
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                74 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            34
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Gustaf Makinen
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                20 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            35
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Selena Manesh
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                10 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            36
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Adam Morrison
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                3 PTS
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                            <div class="col-md-6">
                                <h4>You are ranked <b>90th</b> Worldwide</h4>
                                {{--Replace this stub markup by your code--}}
                                <ul style="padding: 0px;">
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            1
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                María Ayelén Malaquín
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                224 PTS (+112)
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            1
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Ulrike Bruckenberger
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                224 PTS (+112)
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            3
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Kumar Jubar
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                223 PTS (+111)
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            89
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Roberto Muñoz
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                113 PTS (+1)
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            90
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;"><b>Alfred Maroz</b></div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                112 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            91
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Monica Gerculesku
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                110 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            343
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Nileesh Gopu
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                3 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            343
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Adam Morrison
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                3 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            346
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Ezeph Malcom
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                0 PTS
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
