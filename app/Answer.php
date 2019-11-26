<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Question;

class Answer extends Model
{
    // Relationship toward User
    public function user(){

        return $this->belongsTo(User::class);

    }
    // Relationship toward Question
    public function question(){

        return $this->belongsTo(Question::class);

    }

    /** Accesor to parse HTML-like syntax */
    public function getBodyHtmlAttribute(){

        return \Parsedown::instance()->text($this->body);

    }

    /** Here we will watch for our events */

    public static function boot(){

        parent::boot();

        static::created(function($answer){

            /* echo "Answer created\n"; */

            $answer->question->increment('answers_count');

        });

        static::saved(function($answer){

            echo "Answer saved\n";

        });

    }


}
