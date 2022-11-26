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
        Schema::create('userlocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('cointype')->nullable();
            $table->string('address')->nullable();
            $table->softDeletes();
            $table->tinyInteger('state')->default(1);
            $table->integer('duration');
            $table->timestamp('expry')->nullable();
            $table->decimal('amount', 16, 9);
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
        Schema::dropIfExists('userlocks');
    }
};
