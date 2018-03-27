<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogUserVisits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_user_visits', function (Blueprint $table) {
            $table->increments('id');

            $table->string('source');
            $table->integer('source_id');
            $table->integer('card_number');
            $table->string('source_name');
            $table->string('status');
            $table->integer('door');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_user_visits');
    }
}
