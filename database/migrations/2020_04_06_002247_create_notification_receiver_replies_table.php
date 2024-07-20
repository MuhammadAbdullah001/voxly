<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationReceiverRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_receiver_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message');
            $table->unsignedInteger('notifications_id')->default(0);
            $table->unsignedInteger('sender_users_id')->default(0);
            $table->unsignedInteger('receiver_users_id')->default(0);
            $table->foreign('notifications_id')->references('id')->on('notifications')->onDelete('cascade');;
            $table->foreign('sender_users_id')->references('id')->on('users')->onDelete('cascade');;
            $table->foreign('receiver_users_id')->references('id')->on('users')->onDelete('cascade');;
             $table->boolean('sender_user');
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
        Schema::dropIfExists('notification_receiver_replies');
    }
}
