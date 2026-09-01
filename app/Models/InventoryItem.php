<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'tbl_inventory_items';

    protected $fillable = [
        'asset_tag',
        'item_name',
        'category',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'warranty_expiry',
        'assigned_to',
        'department',
        'campaign',           
        'location',
        'status',
        'remarks',
        'history',
        'file_attach',
    ];

    public function campaignHistory()
    {
        return $this->hasMany(Campaign::class, 'inventory_item_id');
    }

    // Mutators
    public function setCampaignAttribute($value)
    {
        $this->attributes['campaign'] = strtoupper($value);
    }

    public function setDepartmentAttribute($value)
    {
        $this->attributes['department'] = strtoupper($value);
    }

    public function setAssignedToAttribute($value)
    {
        $this->attributes['assigned_to'] = strtoupper($value);
    }

    // Accessors
    public function getHistoryAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    // Method to transfer asset to another campaign
    public function transferToCampaign($newCampaign, $newDepartment = null, $newAssignedTo = null)
    {
        // Log the transfer in history
        $history = $this->history ?? [];
        $history[] = [
            'timestamp'   => now()->toDateTimeString(),
            'from_campaign' => $this->campaign,
            'to_campaign'   => $newCampaign,
            'from_department' => $this->department,
            'to_department'   => $newDepartment ?? $this->department,
            'from_assigned_to' => $this->assigned_to,
            'to_assigned_to'   => $newAssignedTo ?? $this->assigned_to,
        ];

        // Update attributes
        $this->campaign    = $newCampaign;
        $this->department  = $newDepartment ?? $this->department;
        $this->assigned_to = $newAssignedTo ?? $this->assigned_to;
        $this->history     = json_encode($history);

        $this->save();

        $this->campaignHistory()->create([
            'campaign' => $this->campaign,
            'department' => $this->department,
            'assigned_to' => $this->assigned_to,
        ]);
    }
}
