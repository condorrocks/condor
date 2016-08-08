<?php

use App\Feed;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class TurnApikeyNullableOnFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feeds', function ($table) {
            $table->string('apikey')->nullable()->change();
        });

        Feed::where(['apikey' => 0])->update(['apikey' => null]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Feed::where(['apikey' => null])->update(['apikey' => 0]);

        Schema::table('feeds', function ($table) {
            $table->string('apikey')->nullable(false)->change();
        });
    }
}
