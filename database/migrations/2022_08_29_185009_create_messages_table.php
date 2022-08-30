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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string("to");
            $table->foreign('to')->references("serial")->on("computers");
            $table->string("from");
            $table->foreign('from')->references("serial")->on("computers");
            $table->longText("message");
            $table->string("attachements");
            $table->boolean("sdp");
            $table->boolean("ice");
            $table->boolean("text");
            $table->boolean("files");
            $table->boolean("read");
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
        Schema::dropIfExists('messages');
    }
};
