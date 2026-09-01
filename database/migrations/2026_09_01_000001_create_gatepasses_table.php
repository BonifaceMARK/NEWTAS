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
        Schema::create('tbl_gatepasses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('owner')->nullable();
            $table->string('contact')->nullable();
            $table->string('bearer')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('site_floor')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('unit')->nullable();
            $table->string('description')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_gatepasses');
    }
};
