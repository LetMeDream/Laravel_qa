<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $questions = Question::all()->pluck('id');

        $numberOfQuestion = count($questions);
        $votes = [-1, 1];

        foreach(User::all() as $user){

            for($i = 0; $i < rand(0,$numberOfQuestion); $i++){


                    $user->voteQuestions()->attach($questions[$i], ['vote' => $votes[rand(0,1)] ] );


            }


        }

    }
}
