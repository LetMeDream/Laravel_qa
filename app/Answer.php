<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Question;
use Carbon\Carbon;

class Answer extends Model
{

    protected $guarded = [];

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

    /** Accesor */
    public function getCreatedDateAttribute(){

        return $this->created_at->diffForHumans();

    }

    /** Accesor to get the best Answer with class='vote-accepted' */
    public function getStatusAttribute(){

        return $this->question->best_answer_id === $this->id ? 'vote-accepted' : 'vote-accept';

    }

    /** Here we will watch out for our events */

    public static function boot(){

        parent::boot();

        /** Eloquent Event; when created */
        static::created(function($answer){

            /* echo "Answer created\n"; */

            $answer->question->increment('answers_count');

        });

        /** Eloquent Event; when saved */
        static::saved(function($answer){

            echo "Answer saved\n";

        });

        static::deleted(function($answer){

            $answer->question->decrement('answers_count');

        });

    }


}
