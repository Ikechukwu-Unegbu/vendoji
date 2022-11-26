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
        Schema::create('unlocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wallet_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('lock_id')->nullable();
            $table->string('reason')->nullable();
            $table->tinyInteger('admin')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('unlocks');
    }
};
