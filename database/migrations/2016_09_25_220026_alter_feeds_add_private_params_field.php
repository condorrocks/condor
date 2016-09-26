<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterFeedsAddPrivateParamsField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->longText('private_params')->after('params')->nullable();
        });

        $this->updateForCompatibility();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->dropColumn('private_params');
        });
    }

    protected function updateForCompatibility()
    {
        // Since the apikey column gets deprecated its now moved as a param key

        DB::table('feeds')
            ->where('aspect_id', 1)
            ->update(['params' => DB::raw("CONCAT('{ \"apikey\":\"', apikey, '\" }')")]);
    }
}
