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
            $table->foreignId('executor_id')->nullable();
            $table->foreignId('offer_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('address');
            $table->text('comment')->nullable();
            $table->foreignId('urgency_id')->nullable();
            $table->date('works_date');
            $table->enum('status',
                                [
                                    'CREATED',
                                    'WAITING_FOR_REPORT',
                                    'AT_WORK',
                                    'REPORT_SENT',
                                    'APPROVED',
                                    'NOT_APPROVED'
                                ]);
            $table->string('image_path')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('executor_id')->references('id')->on('executors');
            $table->foreign('urgency_id')->references('id')->on('urgencies');
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
