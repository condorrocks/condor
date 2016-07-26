<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountBoardPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_board', function (Blueprint $table) {
            $table->integer('account_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('board_id')->unsigned()->index();
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->nullableTimestamps();

            $table->unique(['account_id', 'board_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('account_board');
    }
}
