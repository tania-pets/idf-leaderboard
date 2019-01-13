<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\{Course, CourseEnrollment, User};
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use App\LeaderBoard\{LeaderBoardFactory, LeaderBoardEngine};


class CourseEnrollmentController extends Controller
{
    public function show(string $slug): Renderable
    {
        /** @var Course $course */
        $course = Course::query()
                ->where('slug', $slug)
                ->first() ?? abort(Response::HTTP_NOT_FOUND, 'Course not found');

        $enrollment = CourseEnrollment::query()
            ->where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->with('course.lessons')
            ->first();

        if ($enrollment === null) {
            return view('courses.show', ['course' => $course]);
        }

        //Generate leaderBoard lists
        $leaderBoardTypes = LeaderBoardEngine::LEADERBOARD_TYPES; //country, global
        $allUsersInLeaderBoard = [];
        foreach ($leaderBoardTypes as $lbType) {
            $leaderBoard = LeaderBoardFactory::makeLeaderBoard(auth()->user(), $course, $lbType);
            $leaderBoardList = $leaderBoard->getLeaderBoardList();
            $leaderBoardLists[$lbType] = $leaderBoardList;
            $allUsersInLeaderBoard+=$leaderBoardList;
        }
        //fetch user data from database to display names etc
        $leaderBoardUserData = User::whereIn('id', array_keys($allUsersInLeaderBoard))->get()->groupBy('id');
        
        return view('courseEnrollments.show', ['me' => auth()->user(), 'enrollment' => $enrollment, 'leaderBoardLists' =>$leaderBoardLists, 'leaderBoardUserData' => $leaderBoardUserData ]);
    }

    public function store(string $slug)
    {
        /** @var Course $course */
        $course = Course::query()
                ->where('slug', $slug)
                ->first() ?? abort(Response::HTTP_NOT_FOUND, 'Course not found');

        $enrollment = $course->enroll(auth()->user());

        return redirect()->action([self::class, 'show'], [$course->slug]);
    }
}
