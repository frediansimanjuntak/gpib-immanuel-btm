<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketToActivityRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_registrations', function (Blueprint $table) {
            $table->foreignId('ticket_registration_id')->nullable()->constrained('ticket_registrations')->onDelete('cascade');
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
            $table->dropForeign(['ticket_registration_id']);
        });
    }
}
