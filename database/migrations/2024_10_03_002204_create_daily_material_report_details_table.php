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
        Schema::create('daily_material_report_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daily_report_id');
            $table->string('code', 20);
            $table->string('name', 200);
            $table->char('unit', 10);
            $table->double('qty')->default(0);
            $table->double('price')->default(0);
            $table->double('total_price')->default(0);
            $table->double('weight')->default(0);
            $table->double('total_weight')->default(0);

            $table->foreign('daily_report_id')->on('daily_material_reports')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_material_report_details');
    }
};
