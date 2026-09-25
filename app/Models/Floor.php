<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    protected $table = 'tbl_floors';

    protected $fillable = [
        'floor_no',
        'floor_name',
        'max_workstations',
        'remarks'
    ];

    // Relationship: One floor has many workstations
    public function workstations()
    {
        return $this->hasMany(Workstation::class, 'floor_id');
    }
}
