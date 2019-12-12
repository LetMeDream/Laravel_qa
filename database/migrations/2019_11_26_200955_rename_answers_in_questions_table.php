<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAnswersInQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            // Here is where we will rename the column; STOP JUST MIGRATING:FRESH YOU MOTHERFUCKER /B/STARD

            $table->renameColumn('answers', 'answers_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Questions', function (Blueprint $table) {
            // the opossite of up
            $table->renameColumn('answers_count', 'answers');
        });
    }
}
