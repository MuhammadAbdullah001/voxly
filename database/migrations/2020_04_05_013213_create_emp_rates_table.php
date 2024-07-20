<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emp_calenders_id');
            $table->integer('per_hour_rate');
            $table->integer('staff_teachers_id');
            $table->date('date');
            $table->integer('daily_working_hours');
            $table->integer('pay');
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
        Schema::dropIfExists('emp_rates');
    }
}
