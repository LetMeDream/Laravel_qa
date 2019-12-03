<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\Question;

class VoteAnswerController extends Controller
{
    //
    public function __construct(){

        $this->middleware('auth');

    }

    public function __invoke(Question $question, Answer $answer){

        $vote=(int) request()->vote;



        if(auth()->user()->voteAnswer($answer, $vote)=== 1){
            return back()->with('repeated','You had already voted this');
        } else {
            return back()->with('success','Your vote has been registered');
        }



    }


}
