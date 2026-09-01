<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'tbl_campaigns';

    protected $fillable = [
        'inventory_item_id',
        'campaign',
        'from_campaign',
        'to_campaign',
        'department',
        'from_department',
        'to_department',
        'assigned_to',
        'from_assigned_to',
        'to_assigned_to',
        'moved_at',
        'remarks',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}