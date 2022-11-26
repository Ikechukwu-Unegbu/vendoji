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
        Schema::create('banktransfers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('trxid')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('approval')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('amount_send')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('stake_duration')->nullable();
            $table->tinyInteger('otp')->default()->nullable();
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
        Schema::dropIfExists('banktransfers');
    }
};
