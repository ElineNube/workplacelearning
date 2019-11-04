<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeacherToWplpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workplacelearningperiod', function (Blueprint $table) {
            $table->integer('teacher_id')->nullable(true);
        });

        Schema::table('workplacelearningperiod', function (Blueprint $table) {
            $table->foreign('teacher_id', 'optin_to_teacher_id')
                ->references('student_id')->on('student')->onDelete('CASCADE');
        });
    }

   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workplacelearningperiod', function (Blueprint $table) {
            $table->dropColumn('teacher_id');
            $table->dropForeign('optin_to_teacher_id');
        });
    }
}
