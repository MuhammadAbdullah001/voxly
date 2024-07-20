<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_receivers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('notifications_id')->default(0);
            $table->unsignedInteger('users_id')->default(0);

            $table->foreign('notifications_id')->references('id')->on('notifications')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
             $table->smallInteger('is_seen')->default(0);
             $table->smallInteger('is_active')->default(1);
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
        Schema::dropIfExists('notification_receivers');
    }
}
