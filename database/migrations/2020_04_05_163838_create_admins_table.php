<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('email',60)->unique();
            $table->string('password');
            $table->string('type');
            $table->integer('status')->default(0);
            $table->integer('two_factor_passcode')->default(0);
            $table->string('avatar_url')->nullable();
            $table->text('address');
            $table->string('contact_number');
            $table->bigInteger('cnic')->nullable();
            $table->integer('dob_month')->nullable();
            $table->integer('dob_day')->nullable();
            $table->integer('dob_year')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
