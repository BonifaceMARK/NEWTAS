<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workstation extends Model
{
    use HasFactory;

    protected $table = 'tbl_workstations';

    protected $fillable = [
        'workstation_no',
        'floor_id',
        'hostname',
        'ip_address',
        'mac_address',
        'os',
        'assigned_user',
        'role',
        'status',
        'remarks'
    ];

    // Relationship: Each workstation belongs to one floor
    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }

    // Relationship: One workstation has many statuses
    public function statuses()
    {
        return $this->hasMany(WorkstationStatus::class, 'workstation_id');
    }

    // Relationship: One workstation has many assets
    public function assets()
    {
        return $this->hasMany(WorkstationAsset::class, 'workstation_id');
    }

    // Relationship: One workstation has many PC sweep records
    public function pcSweeps()
    {
        return $this->hasMany(PCSweep::class, 'workstation_id');
    }
}
