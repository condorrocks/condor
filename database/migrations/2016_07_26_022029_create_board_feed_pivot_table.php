<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardFeedPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_feed', function (Blueprint $table) {
            $table->integer('feed_id')->unsigned()->index();
            $table->foreign('feed_id')->references('id')->on('feeds')->onDelete('cascade');
            $table->integer('board_id')->unsigned()->index();
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->nullableTimestamps();

            $table->unique(['feed_id', 'board_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('board_feed');
    }
}
