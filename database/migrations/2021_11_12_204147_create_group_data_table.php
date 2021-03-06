<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId("intern_id")->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("mentor_id")->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("group_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("assignment_id")->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp("start_at")->nullable();
            $table->timestamp("end_at")->nullable();
            $table->boolean("activated")->default(0);
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
        Schema::dropIfExists('group_data');
    }
}
