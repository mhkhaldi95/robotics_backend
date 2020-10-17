<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id")->nullable();
            $table->unsignedBigInteger("item_id")->nullable();
            $table->unsignedBigInteger("student_id")->nullable();
            $table->double("price_unit");
            $table->unsignedBigInteger("tax_id")->nullable();
            $table->unsignedBigInteger("discount_id")->nullable();
            // $table->unsignedBigInteger('stocks_id')->nullable();
            $table->dateTime("approved_at")->nullable();
            $table->integer("quantity")->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
