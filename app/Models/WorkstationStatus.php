<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkstationStatus extends Model
{
    use HasFactory;

    protected $table = 'tbl_workstation_statuses';

    protected $fillable = [
        'workstation_id',
        'task_name',
        'status',
        'remarks'
    ];

    // Relationship: Each status belongs to one workstation
    public function workstation()
    {
        return $this->belongsTo(Workstation::class, 'workstation_id');
    }
}
