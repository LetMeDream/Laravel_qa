<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\User;

class Question extends Model
{
    //
    protected $fillable = ['title', 'body'];

    public function user(){

        return $this->belongsTo(User::class);

    }

    /** Mutator */
    public function setTitleAttribute($value){

        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug( $value );

    }

    /** Accesors */
    public function getUrlAttribute(){

        return route('questions.show', $this->slug);

    }

    public function getCreatedDateAttribute($value){

        return $this->created_at->diffForHumans();

    }

    public function getStatusAttribute(){

        if($this->answers>0){
            if($this->best_answer_id==null){
                return "answered";
            }else{
                return "answered-accepted";
            }

        }
        return "unanswered";

    }

    public function getBodyHtmlAttribute(){

        return \Parsedown::instance()->text($this->body);

    }

}
