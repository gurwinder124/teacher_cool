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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('user_id');
            $table->foreignId('subscription_plan_id')->nullable();
            $table->foreignId('content_id')->nullable();
            $table->tinyInteger('order_type');
            $table->tinyInteger('is_paid')->default(2)->comment('paid=1: not-paid=2');
            $table->string('total_amount');
            $table->string('net_amount');
            $table->string('discount')->default(0);
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
        Schema::dropIfExists('orders');
    }
};
