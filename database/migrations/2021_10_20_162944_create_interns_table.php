<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string("CV")->nullable();
            $table->string("gitHub")->nullable();
            $table->foreignId("group_id")->nullable();
            $table->foreignId("assignment_id")->nullable();
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
        Schema::dropIfExists('interns');
    }
}
