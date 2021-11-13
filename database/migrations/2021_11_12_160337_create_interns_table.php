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
            $table->string('name')->require();
            $table->string('surname')->require();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->text("CV")->nullable();
            $table->string("gitHub")->nullable();
            $table->foreignId("role_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
