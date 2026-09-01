<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_campaigns', function (Blueprint $table) {
            $table->string('from_campaign')->nullable()->after('campaign');
            $table->string('to_campaign')->nullable()->after('from_campaign');
            $table->string('from_department')->nullable()->after('department');
            $table->string('to_department')->nullable()->after('from_department');
            $table->string('from_assigned_to')->nullable()->after('assigned_to');
            $table->string('to_assigned_to')->nullable()->after('from_assigned_to');
            $table->timestamp('moved_at')->nullable()->after('to_assigned_to');
            $table->text('remarks')->nullable()->after('moved_at');
        });

        DB::table('tbl_campaigns')->whereNull('from_campaign')->update([
            'from_campaign' => null,
            'to_campaign' => DB::raw('campaign'),
            'from_department' => null,
            'to_department' => DB::raw('department'),
            'from_assigned_to' => null,
            'to_assigned_to' => DB::raw('assigned_to'),
            'moved_at' => DB::raw('created_at'),
            'remarks' => 'Initial item registration',
        ]);
    }

    public function down(): void
    {
        Schema::table('tbl_campaigns', function (Blueprint $table) {
            $table->dropColumn([
                'from_campaign',
                'to_campaign',
                'from_department',
                'to_department',
                'from_assigned_to',
                'to_assigned_to',
                'moved_at',
                'remarks',
            ]);
        });
    }
};
