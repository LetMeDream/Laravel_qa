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
            $votes = $question->real_votes;


            if(request()->expectsJson()){
                return response()->json([
                    'message' => 'Repeated, you had already voted this',
                    'repeated' => 1,
                    'votes' => $votes
                ]);
            }

            return back()->with('repeated','You had already voted this');
        } else {
            $votes = $question->real_votes;

            if(request()->expectsJson()){
                return response()->json([
                    'message' => 'Your vote was added',
                    'repeated' => 0,
                    'votes' => $votes
                ]);
            }

            return back()->with('success','Your vote has been registered');
        }

    }
}
