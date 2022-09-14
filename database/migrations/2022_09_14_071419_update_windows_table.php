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
        Schema::table('windows', function (Blueprint $table) {       
            $table->string("exists")->change();
            $table->string("visible")->change();
            $table->string("enabled")->change();
            $table->string("active")->change();
            $table->string("maximised")->change();
            $table->string("minimised")->change();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('windows', function (Blueprint $table) {
            $table->boolean("exists")->change();
            $table->boolean("visible")->change();
            $table->boolean("enabled")->change();
            $table->boolean("active")->change();
            $table->boolean("maximised")->change();
            $table->boolean("minimised")->change();
            
        });
    }
};
