<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PCSweep extends Model
{
    use HasFactory;

    protected $table = 'tbl_pc_sweep';

    protected $fillable = [
        'workstation_id',
        'sweep_date',
        'social_media',
        'gmail_access',
        'usb_access',
        'powershell',
        'command_prompt',
        'notepad',
        'sticky_notes',
        'saved_old_files',
        'downloads',
        'game_access',
        'snipping_tool',
        'snip_and_sketch',
        'paint_3d',
        'paint_application',
        'audit_remarks',
        'auditor'
    ];

    // Relationship: Each sweep belongs to one workstation
    public function workstation()
    {
        return $this->belongsTo(Workstation::class, 'workstation_id');
    }
}

