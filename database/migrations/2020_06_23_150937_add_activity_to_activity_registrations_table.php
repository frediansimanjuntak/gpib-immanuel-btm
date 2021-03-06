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
              
            $table->foreignId('activity_id')
                    ->nullable()
                    ->constrained('activities')
                    ->onDelete('cascade');                      
            $table->foreignId('activity_schedule_id')
                    ->nullable()
                    ->constrained('activity_schedules')
                    ->onDelete('cascade');              
            $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->onDelete('cascade');
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
            $table->dropForeign(['user_id', 'activity_schedule_id', 'activity_id']);
        });
    }
}
