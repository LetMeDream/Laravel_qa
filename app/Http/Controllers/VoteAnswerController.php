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

    public function __invoke( Answer $answer){

        $vote=(int) request()->vote;

        /* $x = auth()->user()->voteAnswer($answer, $vote);
        dd($x); */

        if(auth()->user()->voteAnswer($answer, $vote)=== 1){
            /** Sending real votes to the Vue front-end */
            $votes = $answer->real_votes;

            if(request()->expectsJson()){
                return response()->json([
                    'message' => 'Repeated, you had already voted this',
                    'repeated' => 1,
                    'votes' => $votes
                ]);
            }
            return back()->with('repeated','You had already voted this');
        } else {
            /** Sending real votes to the Vue front-end */
            $votes = $answer->real_votes;

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
