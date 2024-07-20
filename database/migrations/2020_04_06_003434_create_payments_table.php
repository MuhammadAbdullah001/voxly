<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amount');
            $table->integer('account_head_id')->default(0);

            $table->integer('bank_account_id');
            $table->string('payment_mode');
            $table->string('payment_remarks');
            $table->string('table_name');
            $table->integer('table_id');
            $table->integer('journal_id');
            $table->string('description');
            $table->date('date');

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
        Schema::dropIfExists('payments');
    }
}
