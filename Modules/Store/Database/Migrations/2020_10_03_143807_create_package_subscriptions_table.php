<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_subscriptions_item_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('expiration_at')->nullable();
            $table->boolean('expired')->nullable();
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
        Schema::dropIfExists('package_subscriptions');
    }
}
