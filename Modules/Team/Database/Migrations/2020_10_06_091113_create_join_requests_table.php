<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJoinRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('join_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('to_team_id')->nullable();
            $table->unsignedBigInteger('from_student_id')->nullable();
            $table->dateTime('approved_at')->nullable();// is not null go to ticket
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('join_requests');
    }
}
