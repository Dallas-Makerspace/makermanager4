<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertMm3UserSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable();

            $table->timestamps();
        });

        // This is direct SQL to prevent Laravel magic timestamps
        DB::update('update users set created_at = created, updated_at = modified');

        Schema::table('users', function (Blueprint $table) {
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
