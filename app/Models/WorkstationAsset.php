<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkstationAsset extends Model
{
    use HasFactory;

    protected $table = 'tbl_workstation_assets';

    protected $fillable = [
        'workstation_id',
        'asset_tag',
        'asset_type',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'warranty_expiry',
        'status',
        'remarks'
    ];

    // Relationship: Each asset belongs to one workstation
    public function workstation()
    {
        return $this->belongsTo(Workstation::class, 'workstation_id');
    }
}
