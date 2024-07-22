<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyConstraintOnAraEvaluations extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ara_evaluations', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['id_criteria']);
            $table->dropForeign(['id_alternative']);

            // Add foreign key constraint with cascade on delete
            $table->foreign('id_criteria')->references('id_criteria')->on('ara_criterias')->onDelete('cascade');
            $table->foreign('id_alternative')->references('id_alternative')->on('ara_alternatives')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ara_evaluations', function (Blueprint $table) {
            // Drop the foreign key constraint with cascade
            $table->dropForeign(['id_criteria']);
            $table->dropForeign(['id_alternative']);

            // Add foreign key constraint without cascade
            $table->foreign('id_criteria')->references('id_criteria')->on('ara_criterias');
            $table->foreign('id_alternative')->references('id_alternative')->on('ara_alternatives');
        });
    }
}
