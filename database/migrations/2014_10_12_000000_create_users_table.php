<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_or_teacher_id');
            $table->string('admission_no');
            $table->string('parent_name');
            $table->string('email',60)->unique();
            $table->string('contact_number');
            $table->string('user_role');
            $table->text('remarks')->nullable();
            $table->text('address');
            $table->string('avatar_url');
            $table->string('projected_revenue')->nullable();
            $table->string('child_care')->nullable();

            $table->string('post_code')->nullable();
            $table->string('class_mode');
            $table->string('landline_no')->nullable();
            $table->string('reffered_by')->nullable();
            $table->string('relation')->nullable();
            $table->string('emergency_contact_no')->nullable();




            $table->integer('is_active')->default(1);
            $table->string('api_token', 60)->unique()->nullable();
            $table->text('fcm_token')->unique()->nullable();
             $table->string('verifyToken')->nullable();
            $table->date('date');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('is_changed_first_password')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
