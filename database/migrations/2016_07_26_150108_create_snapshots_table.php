<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnapshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snapshots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('board_id')->unsigned()->index();
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->integer('aspect_id')->unsigned()->index();
            $table->foreign('aspect_id')->references('id')->on('aspects')->onDelete('cascade');
            $table->string('hash')->index();
            $table->timestamp('timestamp')->useCurrent()->index();
            $table->longText('data');
            $table->string('target')->index();
            $table->timestamps();

            $table->unique(['aspect_id', 'target']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('snapshots');
    }
}
