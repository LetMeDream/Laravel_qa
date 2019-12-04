<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\User;
use App\Answer;

class Question extends Model
{
    //
    protected $fillable = ['title', 'body'];

    /** Relationship toward Users */
    public function user(){

        return $this->belongsTo(User::class);

    }
    /** Relationship toward Answers */
    public function answers(){

        return $this->hasMany(Answer::class);

    }

    /** Many to many relationship (questions<->users)  */
    public function favorites(){

        /** So this user has many favorites questions through 'favorites' pivot table */
        return $this->belongsToMany(User::class, 'favorites');

    }

    /** Many to many Polymorphic relationship (questions<->votables<->user) */
    public function votes(){

        return $this->morphToMany(User::class, 'votable');

    }


    /** Another accesor, this one so we can know if the logged user has favorited this question */
    public function getIsFavoritedAttribute(){

        return isFavorited();

    }

    /** The function to know if the current logged user has favorited this question */
    public function isFavorited(){

        return $this->favorites()->where('user_id', Auth()->id() )->count() > 0; //True if this user has this question as favorite

    }

    public function getIsFavoritedCountAttribute(){

        return $this->favorites->count(); // Counting how many favorites does this question have.

    }

    /** Accesor to know whether current user has favorited que question */
    public function getBeenFavoritedAttribute(){

        $users = $this->favorites()->pluck('user_id');
        $longitud = count($users);

        for($i = 0; $i <= $longitud-1; $i++){

            if($users[$i] === auth()->id()){

                return 'favorited';

            }

        }

        return '';


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

    /** Accesor to get real votes */
    public function getRealVotesAttribute(){

        return $this->votes()->withPivot('vote')->pluck('vote')->sum();

    }

    public function getStatusAttribute(){

        if($this->answers_count>0){
            if($this->best_answer_id==null){
                return "answered";
            }else{
                return "answered-accepted";
            }

        }
        return "unanswered";

    }

    public function getBodyHtmlAttribute(){

        return clean(\Parsedown::instance()->text($this->body));

    }

    /** Accepting best-o Answer */
    public function AcceptBestAnswer($answer){

        if($this->best_answer_id === $answer->id){

            $this->best_answer_id = null;
            $this->save();
            return 1;

        }else{

            $this->best_answer_id = $answer->id;
            $this->save();
            return 2;

        }

    }

    /** Counting up votes */
    public function upVotes(){

        $this->votes()->wherePivot('vote', 1);

    }
    /** Counting down votes */
    public function downVotes(){

        $this->votes()->wherePivot('vote', -1);

    }

}
