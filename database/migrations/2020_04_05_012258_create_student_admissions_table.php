<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_admissions', function (Blueprint $table) {
            $table->increments('id');
             $table->string('admission_no');
            $table->date('date');
            $table->string('school_name');
            $table->string('student_name');
            $table->string('package_type')->nullable();
            $table->string('group_id');
            $table->text('remarks')->nullable();
            $table->text('subject_id');
            $table->text('subject_name');
            $table->text('assessment_result')->nullable();
            $table->text('address')->nullable();
            $table->text('status');
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
        Schema::dropIfExists('student_admissions');
    }
}
