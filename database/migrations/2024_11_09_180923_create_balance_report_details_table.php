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
        Schema::create('balance_report_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('balance_id');
            $table->string('code', 20);
            $table->string('name', 200);
            $table->char('unit', 10);
            $table->double('qty')->default(0);
            $table->string('status', 100);
            $table->string('note', 200)->nullable();

            $table->foreign('balance_id')->on('balance_reports')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_report_details');
    }
};
