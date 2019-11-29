<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AcceptAnswerController extends Controller
{
    //
    public function __invoke(Answer $answer){

        /* Please, remember to fucking authorize your policies in the BACK END */
        $this->authorize('accept_answer', $answer);

        /** Function to be defined in Question Model */
        $random = $answer->question->acceptBestAnswer($answer);

        if($random===1){
            return back()->with('success', 'The answer is no longer the best answer.');
        }else{
            return back()->with('success', 'The answer was accepted as best answer.');
        }




    }

}
