<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRegistrationDateToTicketRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_registrations', function (Blueprint $table) {            
            $table->dateTime('registration_start_date')->change();
            $table->dateTime('registration_end_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_registrations', function (Blueprint $table) {
            //
        });
    }
}
