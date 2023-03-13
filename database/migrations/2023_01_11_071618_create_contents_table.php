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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->foreignId('content_types_id');
            $table->integer('content_category');
            $table->string('name');
            $table->string('keyword');
            $table->longText('description')->nullable();
            $table->string('path');
            $table->string('page_count');
            $table->string('word_count')->nullable();
            $table->tinyInteger('uploaded_by_admin')->default(2);
            $table->tinyInteger('is_approved')->default(1);
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
        Schema::dropIfExists('contents');
    }
};
