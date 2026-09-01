<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gatepass extends Model
{
    use HasFactory;

    protected $table = 'tbl_gatepasses';

    protected $fillable = [
        'item_id',
        'owner',
        'contact',
        'bearer',
        'date',
        'time',
        'site_floor',
        'quantity',
        'unit',
        'description',
        'remarks',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }
}
