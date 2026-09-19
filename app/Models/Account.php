<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'tbl_accounts';

    protected $fillable = [
        'fullname',
        'nas_username',
        'nas_password',
        'ad_username',
        'ad_password',
        'ad_domain',
        'ad_email',
        'sip_extension',
        'sip_password',
        'agent_number',
        'sip_server_ip',
        'campaign',
        'position',
        'level',
        'team',
        'status',
        'remarks',
    ];

    // Optional: default casting
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
