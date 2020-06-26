<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivityToActivitySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_schedules', function (Blueprint $table) {         
            $table->foreignId('activity_id')
                    ->nullable()
                    ->constrained('activities')
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
        Schema::table('activity_schedules', function (Blueprint $table) {
            $table->dropForeign(['activity_id']);
        });
    }
}
