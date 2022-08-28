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
        Schema::create('computer_state', function (Blueprint $table) {
            $table->id();
            $table->boolean("active");
            $table->boolean("idle");
            $table->datetime("epoch");
            $table->string("computer_serial");
            $table->foreign('computer_serial')->references("serial")->on("computers");
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
        Schema::dropIfExists('computer_state');
    }
};
