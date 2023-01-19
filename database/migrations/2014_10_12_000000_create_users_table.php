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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('profile_path')->nullable();
            $table->tinyInteger('user_type')->default(2)->comment('Teacher=1; Student=2');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('teacher_status')->default(0);
            $table->tinyInteger('requested_for_teacher')->default(0);
            $table->tinyInteger('is_newsletter_subscriber')->default(0);
            $table->integer('reffer_user_id')->nullable();
            $table->string('reffer_code')->nullable();
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
