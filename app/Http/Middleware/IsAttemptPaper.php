<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\AssignPaperStudents;

class IsAttemptPaper
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $assign_paper = AssignPaperStudents::whereId($request->id)->first();

        if ($assign_paper->status == 'Submitted')
            return redirect()->to('/in-progress-papers')->with('message', 'You Already Attempt The Paper!');

        return $next($request);
    }
}
