<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("intern_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("assignment_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text("pro");
            $table->text("con");
            $table->timestamp("evaluation_day");
            $table->foreignId("mentor_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('evaluations');
    }
}
