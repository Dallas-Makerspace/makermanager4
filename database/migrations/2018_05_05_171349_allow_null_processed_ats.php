<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowNullProcessedAts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whmcs_hooks', function(Blueprint $table) {
            DB::statement('ALTER TABLE whmcs_hooks MODIFY processed_at datetime DEFAULT NULL;');
        });

        Schema::table('smartwaiver_hooks', function(Blueprint $table) {
            DB::statement('ALTER TABLE smartwaiver_hooks MODIFY processed_at datetime DEFAULT NULL;');
        });

        \DB::table('whmcs_hooks')->update(['processed_at' => null]);
        \DB::table('smartwaiver_hooks')->update(['processed_at' => null]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
