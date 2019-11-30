<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** We would need this line of code down below if we weren't migrating:fresh our databases */
        //\DB::table('favorites')->delete();

        $users = App\User::pluck('id')->all(); //Array

        $numberOfUsers = count($users);

        foreach(Question::all() as $question){

            /** Everysingle question will be favorited by, at-least, one user */
            for($i = 0; $i <= rand(1, $numberOfUsers-1); $i++){
                /** User of the current FOR iteration */
                $user = $users[$i];
                /** To be attached to the question of the current FOREACH iteration */
                $question->favorites()->attach($user);

            }

        }

    }
}
