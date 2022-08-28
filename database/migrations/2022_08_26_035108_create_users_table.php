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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("username");
            $table->string("email")->unique();
            $table->string("phone")->unique();
            $table->string("password");
            $table->string("role");
            $table->unsignedBigInteger('company_id')->unsigned()->index()->nullable();
            $table->foreign('company_id')->references("id")->on("company");
            $table->unsignedBigInteger('role_id')->unsigned()->index()->nullable();
            $table->foreign('role_id')->references("id")->on("roles");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
