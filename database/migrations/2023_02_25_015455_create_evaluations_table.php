<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::disableForeignKeyConstraints();
        
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->date('date_evaluated');
            $table->text('evaluation');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('kpi_id')->references('id')->on('kpis');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
