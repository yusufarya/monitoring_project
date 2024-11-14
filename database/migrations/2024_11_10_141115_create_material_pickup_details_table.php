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
        Schema::create('material_pickup_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_pickup_id');
            $table->string('code', 20);
            $table->string('name', 200);
            $table->char('unit', 10);
            $table->double('qty')->default(0);

            $table->foreign('material_pickup_id')->on('material_pickups')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_pickup_details');
    }
};
