<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('journal_id');
            $table->integer('account_head_id');
            $table->integer('amount');
            $table->string('type');
            $table->date('date');
            $table->text('description');
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
        Schema::dropIfExists('ledger');
    }
}
