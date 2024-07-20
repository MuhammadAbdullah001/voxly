<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduledMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_meetings', function (Blueprint $table) {

            $table->increments('id');
            $table->string('parent_name');
            $table->integer('admission_no');
            $table->string('contact_number');
            $table->time('time_from');
            $table->time('time_to');
            $table->date('arrival_date');
            $table->date('actual_arrival_date')->nullable();
            $table->integer('meeting_pass')->default(0);
            $table->string('email');
            $table->time('actual_arrival_time')->nullable();
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('scheduled_meetings');
    }
}
