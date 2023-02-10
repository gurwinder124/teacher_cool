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
        Schema::create('teacher_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique();
            $table->string('id_proof')->nullable();
            $table->string('document_path')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('expected_income')->nullable();
            $table->string('preferred_currency')->nullable();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
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
        Schema::dropIfExists('teacher_settings');
    }
};
