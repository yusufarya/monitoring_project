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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(date('Y-m-d'));
            $table->string('supervisor_name', 100);
            $table->string('operator_name', 100);
            $table->string('spk_number', 200);
            $table->string('project_name', 200);
            $table->date('start_date')->default(date('Y-m-d'));
            $table->date('end_date')->default(date('Y-m-d'));
            $table->string('contractor_name', 100);
            $table->string('location_project', 100);
            $table->string('value_contract', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
