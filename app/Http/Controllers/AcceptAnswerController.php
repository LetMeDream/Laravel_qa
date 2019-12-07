<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AcceptAnswerController extends Controller
{
    // Function __invoke will always be called when we are in SINGLE ACTION CONTROLLERS
    public function __invoke(Answer $answer){

        /* Please, remember to fucking authorize your policies in the BACK END */
        $this->authorize('accept_answer', $answer);

        /** Function to be defined in Question Model */
        $random = $answer->question->acceptBestAnswer($answer);

        if($random===1){

            if(request()->expectsJson()){
                return response()->json([
                    'message' => 'Answer is no longer favorite'
                ]);
            }

            return back()->with('success', 'The answer is no longer the best answer.');
        }else{

            if(request()->expectsJson()){
                return response()->json([
                    'message' => 'Answer selected as favorite'
                ]);
            }
            return back()->with('success', 'The answer was accepted as best answer.');
        }




    }

}
