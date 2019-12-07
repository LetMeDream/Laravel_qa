<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class FavoriteQuestionController extends Controller
{
    //Last but note least
    public function __construct(){

        $this->middleware('auth');

    }

    public function __invoke(Question $question){

        $users = $question->favorites->pluck('id');
        $length = count($users);

        /* dd($users); */
        $notFavorited = true;

        for($i=0; $i <= $length-1; $i++ ){

            if(auth()->id() == $users[$i]){

                $notFavorited = false;

            }

        }
        if($notFavorited){

            $question->favorites()->attach(auth()->id());

            if(request()->expectsJson()){

                return response()->json([
                    'message' => 'Message at NOTFAVORITES',
                    'favorit' => 1
                ]);

            }


            return back()->with('success', 'The question has been favorited');

        }else{

            $question->favorites()->detach(auth()->id());

            if(request()->expectsJson()){

                return response()->json([
                    'message' => 'Message NOT at FAVORITED',
                    'favorit' => 0
                ]);

            }


            return back()->with('success', 'The question is no longer a favorite');
        }



    }
}
