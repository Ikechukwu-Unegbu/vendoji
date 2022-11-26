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
        Schema::create('adminincomes', function (Blueprint $table) {
            $table->id();
            $table->string('model')->nullable();
            $table->bigInteger('model_id')->nullable();
            $table->string('cointype')->nullable();
            $table->decimal('amount', 20, 12)->nullable();
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
        Schema::dropIfExists('adminincomes');
    }
};
