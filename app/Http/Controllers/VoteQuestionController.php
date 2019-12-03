<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class VoteQuestionController extends Controller
{
    //
    public function __construct(){

        $this->middleware('auth');

    }

    public function __invoke(Question $question){

        $vote = (int) request()->vote;

        /* dd(auth()->user()->voteQuestion($question, $vote) ); */
        if(auth()->user()->voteQuestion($question, $vote)=== 1){
            return back()->with('repeated','You had already voted this');
        } else {
            return back()->with('success','Your vote has been registered');
        }

    }
}
