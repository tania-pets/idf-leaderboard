<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    public function index(): Renderable
    {
        /** @var User $me */
        $me = auth()->user();
        $myEnrollments = $me->courseEnrollments;

        return view('home', [
            'user' => $me,
            'myEnrollments' => $myEnrollments,
        ]);
    }
}
