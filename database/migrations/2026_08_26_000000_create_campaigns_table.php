<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_campaigns', function (Blueprint $table) {
            $table->id();
            $table->integer('inventory_item_id');
            $table->foreign('inventory_item_id')
                ->references('id')
                ->on('tbl_inventory_items')
                ->cascadeOnDelete();
            $table->string('campaign');
            $table->string('department')->nullable();
            $table->string('assigned_to')->nullable();
            $table->timestamps();
        });

        DB::table('tbl_inventory_items')
            ->whereNotNull('campaign')
            ->where('campaign', '<>', '')
            ->orderBy('id')
            ->each(function ($item): void {
                $createdAt = $item->created_at ?? now();

                DB::table('tbl_campaigns')->insert([
                    'inventory_item_id' => $item->id,
                    'campaign' => $item->campaign,
                    'department' => $item->department,
                    'assigned_to' => $item->assigned_to,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_campaigns');
    }
};