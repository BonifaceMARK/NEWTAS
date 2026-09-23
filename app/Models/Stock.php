<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'tbl_stock';

    protected $primaryKey = 'stock_id';

    protected $fillable = [
        'item_name',
        'category',
        'brand',
        'model',
        'quantity',
        'unit',
        'reorder_level',
        'location',
        'remarks',
    ];
}