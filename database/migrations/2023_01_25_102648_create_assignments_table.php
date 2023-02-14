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
            $table->string('amount');
            $table->foreignId('user_id');
            $table->foreignId('teacher_id')->dafault(0);
            $table->longText('question')->nullable();
            $table->tinyInteger('category');
            $table->string('title');
            $table->string('keyword');
            $table->string('assingment_path')->nullable();
            $table->longText('assignment_answer')->nullable();
            $table->string('assignment_answer_path')->nullable();
            $table->tinyInteger('assignment_status')->dafault(1)->comment('pending=1; submitted=2; approved=3');
            $table->tinyInteger('is_paid_to_teacher')->dafault(0)->comment('not-paid=0; paid=1;');;
            $table->dateTime('due_date');
            $table->dateTime('answered_on')->nullable();
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
