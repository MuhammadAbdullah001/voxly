<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subjects_id');
            $table->string('subjects_name');
            $table->string('assigned_group');
            $table->string('assigned_group_id');
            $table->integer('staff_teachers_id');
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
        Schema::dropIfExists('assigned_subjects');
    }
}
