<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StudentAddAnalyticsFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student', function(Blueprint $table) {
            $table->boolean("is_in_analytics")->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student', function(Blueprint $table) {
            $table->dropColumn("is_in_analytics");
        });
    }
}
