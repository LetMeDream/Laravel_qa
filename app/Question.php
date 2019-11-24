<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

        $this->attribute['title'] = $value;
        $this->attribute['slug'] = str_slug( $value );

    }

}
