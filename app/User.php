<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Question;
use App\Answer;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = ['url', 'avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** Relationship towards questions */
    public function questions(){

        return $this->hasMany(Question::class);

    }
    /** Relationship towards answers */
    public function answers(){

        return $this->hasMany(Answer::class);

    }

    /** Accesor */

    public function getUrlAttribute(){

        return '#';

    }

    /** Accesor */

    public function getAvatarAttribute(){

        /** This was brought from Gravatar */
        $email = $this->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    }

    /** Many to many relationship (users<->questions) */
    public function favorites(){

        /** So this user has many favorites questions through 'favorites' pivot table */
        return $this->belongsToMany(Question::class, 'favorites');

    }

    /** Many to many Polymorphic relationship (questions<->users(by voting (votables))<->answers) */
    /** Relationship method */
    public function voteQuestions(){

        return $this->morphedByMany(Question::class, 'votable');

    }
    /** Voting question method */
    public function voteQuestion(Question $question, $vote){

        $voteQuestions = $this->voteQuestions();

        /** We need to know if this user has voted this question */
        /* if( $voteQuestions->where('votable_id', $question->id)->exists() ){
            if($voteQuestions->where('votable_id', $question->id)->withPivot('vote')->pluck('vote')->get(0) === $vote){
                    return 1;
            }
            $voteQuestions->updateExistingPivot($question->id, ['vote' => $vote]);

        }else{
            $voteQuestions->attach($question->id, ['vote' => $vote]);
        } */

        if($this->_vote($voteQuestions, $question, $vote) === 1 ){
            return 1;
        }


    }


    /** Relationship method */
    public function voteAnswers(){

        return $this->morphedByMany(Answer::class, 'votable');

    }
    /** Voting answer method */
    public function voteAnswer(Answer $answer, $vote){

        $voteAnswers = $this->voteAnswers();

        if($this->_vote($voteAnswers, $answer, $vote)===1){
            return 1;
        }


    }

    /** Refactoring votes functionality */
    public function _vote($relationship, $model, $vote){

        /** if this has already been voted */
        if( $relationship->where('votable_id', $model->id)->exists() ){

            if($relationship->where('votable_id', $model->id)->withPivot('user')->pluck('vote')->get(0) === $vote){
                /** And voted this same vote */
                return 1;
            }
            /** Update if he had already voted but wishes to change the vote */
            $relationship->updateExistingPivot($model->id, ['vote' => $vote]);
        }
        else{
            /** Vote if he had not */
            $relationship->attach($model->id,['vote' => $vote]);

        }

        /** Then we sortof needed to refresh and recount */
        $model->load('votes');

         /** UNUSED ALL OF THIS DOWN BELOW SINCE WE DON'T ACCESS VOTES_COUNT COLUMN */
        /** Counting positive votes */
        $positive = $model->votes()->wherePivot('vote', 1)->pluck('vote')->sum();
        /** Counting negative votes */
        $negative = $model->votes()->wherePivot('vote', -1)->pluck('vote')->sum();
        /** Result */
        $total = $positive + $negative; /** $total = (int) $question->withPivot('vote')->pluck('vote')->sum(); */
        $model->votes_count = $total;
        $model->save();

        /* return $model->votes_count; */

    }




}
