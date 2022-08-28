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
        Schema::create('windows', function (Blueprint $table) {
            $table->id();            $table->string("window");
            $table->boolean("exists");
            $table->boolean("visible");
            $table->boolean("enabled");
            $table->boolean("active");
            $table->boolean("maximised");
            $table->boolean("minimised");
            $table->string("process");
            $table->string("computer_serial");
            $table->foreign('computer_serial')->references("serial")->on("computers");
            $table->datetime("epoch");
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
        Schema::dropIfExists('windows');
    }
};
