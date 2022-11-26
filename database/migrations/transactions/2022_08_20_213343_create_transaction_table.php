<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('amount')->nullable();
            $table->string('account_number')->nullable();
            $table->bigInteger('bank_id')->nullable();
            $table->string('trx_id')->nullable();
            $table->string('trx_ref')->nullable();
            $table->string('payment_type')->nullable();
            $table->enum('trx_type', ['contribution', 'withdrawal'])->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('transaction');
    }
};
