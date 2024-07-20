<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_teachers', function (Blueprint $table) {



            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('type');
            $table->integer('pay');
            $table->integer('timesheet_required_for_salary')->default(1);
            $table->integer('per_hour_rate');
            $table->integer('daily_working_hours');
            $table->date('joining_date');
            $table->date('resigning_date');
            $table->string('comments')->nullable();
            $table->string('email',60)->unique();

            $table->integer('is_resigned')->default(0);
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
        Schema::dropIfExists('staff_teachers');
    }
}
