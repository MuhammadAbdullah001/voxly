<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('admission_no');
            $table->integer('student_admissions_id')->default(0);

            $table->date('from_date');
            $table->date('to_date');
            $table->string('entry_date');
            $table->string('description')->nullable();
             $table->string('paid_duration');
            $table->string('payment_type');
            $table->double('agreed_hrs')->default(0);
            $table->double('agreed_fee_per_hr')->default(0);
             $table->double('expected_amount')->default(0);
            $table->string('status');
            $table->integer('notification_sent_1_day')->nullable()->default(0);
            $table->integer('notification_sent_3_day')->nullable()->default(0);
            $table->integer('notification_sent_10_day')->nullable()->default(0);


            $table->integer('created_by');

            $table->double('amount_taken')->default(0);
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
        Schema::dropIfExists('student_fees');
    }
}
