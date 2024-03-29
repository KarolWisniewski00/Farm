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
        Schema::create('users', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('nickname')->unique();
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('admin');
            $table->boolean('cow');
            $table->boolean('chicken');
            $table->integer('character');
            $table->json('map_data');
            $table->integer('coins');
            $table->json('missions');
            $table->json('dict_seeding_count');
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
