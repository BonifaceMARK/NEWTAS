<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'date_of_transfer',
        'from_campaign',
        'to_campaign',
        'asset_type',
        'remarks',
    ];

    
}
