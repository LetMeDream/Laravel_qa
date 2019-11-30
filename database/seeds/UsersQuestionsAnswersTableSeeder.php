<?php

use Illuminate\Database\Seeder;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** In case we didn't wanted to run migrate:fresh, we should have to dele the already created tables before running this command.
         *  We can do so by */

        //\DB::table('answers')->delete();
        //\DB::table('questions')->delete();
        //\DB::table('users')->delete();

        /** Also, for some unknown reason, we should run those delete() methods in the inverse order to which they were created in the past. */

        factory(App\User::class, 5)->create()->each(function($user){

            $user->questions()->saveMany(factory(App\Question::class, 5)->make())->each(

                function($question){
                    $question->answers()->saveMany(

                        factory(App\Answer::class, rand(0,10))->make()

                );
            }
        );

    });
    }
}
