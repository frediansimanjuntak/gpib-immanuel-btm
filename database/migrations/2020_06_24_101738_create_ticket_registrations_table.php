<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('max_participants');
            $table->string('status');
            $table->date('registration_start_date');
            $table->date('registration_end_date');
            $table->foreignId('activity_id')
                    ->nullable()
                    ->constrained('activities')
                    ->onDelete('cascade');
            $table->foreignId('activity_schedule_id')
                    ->nullable()
                    ->constrained('activity_schedules')
                    ->onDelete('cascade');
            $table->foreignId('created_by')
                    ->nullable()
                    ->constrained('users')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('ticket_registrations');
    }
}
