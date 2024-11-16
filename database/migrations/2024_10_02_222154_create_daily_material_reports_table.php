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
        Schema::create('daily_material_reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->string('spk_number', 200);
            $table->string('project_name', 200);
            $table->string('contractor_name', 100);
            $table->string('location_project', 100);
            $table->string('value_contract', 100);
            $table->string('value_total_job', 100);
            $table->string('value_total_material', 100);
            $table->date('date')->default(date('Y-m-d'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_material_reports');
    }
};