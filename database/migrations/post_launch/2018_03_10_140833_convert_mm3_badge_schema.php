<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertMm3BadgeSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('badge_histories', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('badges', function (Blueprint $table) {
            $table->timestamps();
        });

        // This is direct SQL to prevent Laravel magic timestamps
        DB::update('update badge_histories set created_at = created, updated_at = created');
        DB::update('update badges set created_at = created, updated_at = modified');

        Schema::table('badge_histories', function (Blueprint $table) {
            $table->dropColumn(['created']);
        });
        Schema::table('badges', function (Blueprint $table) {
            $table->dropColumn(['created','modified']);
        });
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
