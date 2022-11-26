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
        Schema::create('walletdeets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('password')->nullable();
            $table->string('pass_phrase')->nullable();
            $table->enum('coin_type', ['btc', 'eth']);
            $table->decimal('balance')->nullable();
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
        Schema::dropIfExists('walletdeets');
    }
};
