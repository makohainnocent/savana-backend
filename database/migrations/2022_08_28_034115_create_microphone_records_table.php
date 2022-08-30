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
        Schema::create('microphone_records', function (Blueprint $table) {
            $table->id();
            $table->string("file");
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
        Schema::dropIfExists('microphone_records');
    }
};
