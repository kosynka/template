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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable();
            $table->foreignId('executor_id')->nullable();
            $table->enum('type', ['report_before', 'report_after']);
            $table->json('image_path');
            $table->string('comment');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('executor_id')->references('id')->on('executors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
