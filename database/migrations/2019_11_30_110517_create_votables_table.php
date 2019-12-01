<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votables', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('votable_id');
            $table->string('votable_type');
            $table->tinyInteger('vote')->comment('1: Vote up, -1: Vote down');
            $table->timestamps();

            /** Remember a user can only vote, up or down, a question/answer once; so */
            $table->unique(['user_id', 'votable_id', 'votable_type']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votables');
    }
}
