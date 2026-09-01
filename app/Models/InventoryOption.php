<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryOption extends Model
{
    use HasFactory;

    protected $table = 'tbl_inventory_options';

    protected $fillable = [
        'option_type',
        'option_value',
    ];
}