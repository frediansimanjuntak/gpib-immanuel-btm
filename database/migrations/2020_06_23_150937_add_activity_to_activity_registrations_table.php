<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivityToActivityRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('activity_schedule_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('activity_schedule_id')->references('id')->on('activity_schedules');
            $table->foreign('user_id')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_registrations', function (Blueprint $table) {
            $table->dropForeign('activity_registrations_activity_id_foreign');
            $table->dropForeign('activity_registrations_activity_schedule_foreign');
            $table->dropForeign('activity_registrations_user_id_foreign');
        });
    }
}
