<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ara_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alternative');
            $table->unsignedBigInteger('id_criteria');
            $table->float('value');
            $table->timestamps();

            $table->foreign('id_alternative')->references('id_alternative')->on('ara_alternatives');
            $table->foreign('id_criteria')->references('id_criteria')->on('ara_criterias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ara_evaluations');
    }
};