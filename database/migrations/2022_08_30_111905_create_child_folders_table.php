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
        Schema::create('child_folders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("folder_id");
            $table->string("computer_serial");
            $table->foreign('folder_id')->references("id")->on("folders");
            $table->foreign('computer_serial')->references("serial")->on("computers");
            $table->String("name");
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
        Schema::dropIfExists('child_folders');
    }
};
