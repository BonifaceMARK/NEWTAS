<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_inventory_options', function (Blueprint $table) {
            $table->id();
            $table->string('option_type', 50);
            $table->string('option_value', 255);
            $table->timestamps();
            $table->unique(['option_type', 'option_value']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_inventory_options');
    }
};