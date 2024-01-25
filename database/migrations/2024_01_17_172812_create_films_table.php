<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('year');
            $table->string('genre', 50);
            $table->string('country', 30);
            $table->integer('duration');
            $table->string('img_url', 255);
            $table->string('agencia', 100); // New field 'agencia' with max lengh 100 char
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
