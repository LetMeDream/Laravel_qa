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

}
