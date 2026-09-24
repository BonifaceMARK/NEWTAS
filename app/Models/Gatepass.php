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
    'status',
    'owner_signature',
    'owner_signed_by',
    'owner_signed_at',
    'remarks',
    'entry_by',
];
public function creator()
{
    return $this->belongsTo(User::class, 'entry_by');
}
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }
 public function signatures()
{
    return $this->hasMany(GatepassSignature::class, 'gatepass_id');
}
}
