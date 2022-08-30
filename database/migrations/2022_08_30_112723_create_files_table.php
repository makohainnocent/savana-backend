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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("folder_id");
            $table->foreign('folder_id')->references("id")->on("folders");
            $table->string("computer_serial");
            $table->foreign('computer_serial')->references("serial")->on("computers");
            $table->String("name");
            $table->string("path");
            $table->String("extension");
            $table->String("size");
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
        Schema::dropIfExists('files');
    }
};
