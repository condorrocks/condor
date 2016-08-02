<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSnapshotsUniqueIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('snapshots', function (Blueprint $table) {
            $table->dropUnique('snapshots_aspect_id_target_unique');

            $table->integer('feed_id')->after('aspect_id')->unsigned()->index();
            $table->foreign('feed_id')->references('id')->on('feeds')->onDelete('cascade');

            $table->unique(['board_id', 'aspect_id', 'feed_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // ...
    }
}
