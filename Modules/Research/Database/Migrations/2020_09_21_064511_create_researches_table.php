<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('researches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            // $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();//owner
            $table->string('user_type')->nullable();
            $table->dateTime('approved_at')->nullable();// accept from admin
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
        Schema::dropIfExists('researches');
    }
}
