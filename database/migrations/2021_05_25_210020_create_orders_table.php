<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->string('phone_number')->nullable();
            $table->enum('status', ['new', 'is_pending', 'in_progress', 'done_by_master', 'checking_by_manager', 'completed', 'cancelled']);
            $table->unsignedBigInteger('master_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('address')->nullable();
            $table->float('total_cost')->nullable();
            $table->float('platform_fee')->nullable();
            $table->text('comment')->nullable();
            $table->text('cancel_reason')->nullable();

            $table->foreign('master_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
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
}
