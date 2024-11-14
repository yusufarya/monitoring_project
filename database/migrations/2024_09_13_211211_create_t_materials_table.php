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
        Schema::create('t_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('code', 20);
            $table->string('name', 200);
            $table->char('unit', 10);
            $table->double('qty')->default(0);
            $table->double('price')->default(0);
            $table->double('total_price')->default(0);
            $table->timestamps();

            $table->foreign('project_id')->on('projects')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_materials');
    }
};
