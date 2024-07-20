<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpCalandersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_calanders', function (Blueprint $table) {



            $table->increments('id');
            $table->integer('month');
            $table->integer('week');
            $table->text('days_json_monthly');
            $table->text('days_json_weekly');
            $table->integer('no_days');
            $table->integer('no_hours');
            $table->integer('is_locked')->default(0);
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
        Schema::dropIfExists('emp_calanders');
    }
}
