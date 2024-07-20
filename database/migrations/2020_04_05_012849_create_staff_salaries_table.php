<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_salaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_teachers_id');
            $table->string('description')->nullable();
            $table->integer('per_hour_rate');
            $table->integer('working_hours');
            $table->integer('employee_worked_hours')->nullable();
            $table->integer('overtime_hours')->nullable();
            $table->integer('calculated_monthly_salary')->nullable();
            $table->integer('calculated_overtime_salary')->nullable();
            $table->integer('calculated_daily_salary')->nullable();
            $table->double('amount_taken');
            $table->double('expected_amount');
            $table->date('daily_salary_date')->nullable();
            $table->string('week')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('status')->default("unpaid");
            $table->string('payment_type');
            $table->date('salary_from_date');
            $table->date('salary_to_date');

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
        Schema::dropIfExists('staff_salaries');
    }
}
