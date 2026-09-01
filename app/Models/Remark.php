<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TasFile;
class InventoryItem extends Model
{

    protected $table = 'InventoryItem_files';

    protected $fillable = ['tas_file_id', 'remark'];

    
}
