<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class GatepassSignature extends Model
{
    protected $table = 'tbl_gatepasses_signatures';

    protected $fillable = [
        'gatepass_id',
        'role',
        'fullname',
        'signature',
        'signed_at',
    ];

    public function gatepass()
    {
        return $this->belongsTo(Gatepass::class);
    }
}
