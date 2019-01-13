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
                            @foreach ($leaderBoardLists as $lbType => $lbUsers)
                                <div class="col-md-6">
                                    <h4>You are ranked <b>{{\App\LeaderBoard\LeaderBoardEngine::withOrdinalSuffix($lbUsers[$me->id]['rank'])}}</b>
                                        {{ $lbType=='country' ? "in " .$me->country->name : 'Worldwide' }}
                                    </h4>

                                    <ul style="padding: 0px;">

                                    @foreach ($lbUsers as $lbUserId => $lbInfo)
                                        <?php if((isset($prevRank) &&  $lbInfo['rank'] - $prevRank > 1) ||  ( isset($prevRank) && ($lbInfo['rank'] - $prevRank ==1) &&  $lbInfo['rank'] == \App\LeaderBoard\LeaderBoardEngine::getConf('leaders_shown') + 1))
                                            echo '<hr>';
                                        ?>
                                        <li class="courseRanking__rankItem"
                                            style="display: flex; flex-direction: row; padding: 10px;">
                                            <div class="position"
                                                 style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                                {{$lbInfo['rank']}}
                                            </div>
                                            <div class="info">
                                                <div style="font-size: 16px;">
                                                    @if($lbUserId == $me->id)
                                                        <b>{{$leaderBoardUserData[$lbUserId][0]->name}}</b>
                                                    @else
                                                        {{$leaderBoardUserData[$lbUserId][0]->name}}
                                                    @endif
                                                </div>
                                                <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                    {{$lbInfo['score']}} PTS
                                                     @if($lbUsers[$me->id]['score'] < $lbInfo['score'])
                                                     (+{{$lbInfo['score'] - $lbUsers[$me->id]['score']}})
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                        <?php $prevRank = $lbInfo['rank'] ?>
                                    @endforeach
                                    </ul>

                                </div>
                            @endforeach



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
