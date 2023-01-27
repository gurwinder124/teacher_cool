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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('assignment_id');
            $table->foreignId('user_id');
            $table->foreignId('teacher_id')->dafault(0);
            $table->longText('question')->nullable();
            $table->tinyInteger('category');
            $table->string('title');
            $table->string('keyword');
            $table->string('assingment_path')->nullable();
            $table->longText('assignment_answer')->nullable();
            $table->string('assignment_answer_path')->nullable();
            $table->tinyInteger('assignment_status');
            $table->tinyInteger('is_paid_to_teacher');
            $table->dateTime('due_date');
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
        Schema::dropIfExists('assignments');
    }
};
