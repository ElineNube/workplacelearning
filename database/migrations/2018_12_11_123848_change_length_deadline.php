<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLengthDeadline extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('deadline', function (Blueprint $table) {
            $table->string('dl_value', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('deadline', function (Blueprint $table) {
            $table->string('dl_value', 45)->change();
        });
    }
}
