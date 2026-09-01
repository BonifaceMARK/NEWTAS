<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use Illuminate\Database\Seeder;

class InventoryItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'asset_tag' => 'ASI-LT-0001',
                'item_name' => 'Business Laptop',
                'category' => 'Laptop',
                'brand' => 'Dell',
                'model' => 'Latitude 5440',
                'serial_number' => 'DL5440-0001',
                'assigned_to' => 'Maria Santos',
                'department' => 'Operations',
                'campaign' => 'Project Atlas',
                'location' => 'Head Office',
                'status' => 'Assigned',
                'purchase_date' => '2025-01-15',
                'warranty_expiry' => '2028-01-15',
                'remarks' => 'Primary work laptop',
            ],
            [
                'asset_tag' => 'ASI-MN-0001',
                'item_name' => 'Office Monitor',
                'category' => 'Monitor',
                'brand' => 'Acer',
                'model' => 'B247Y',
                'serial_number' => 'ACB247Y-0001',
                'assigned_to' => 'John Reyes',
                'department' => 'Finance',
                'campaign' => 'Project Atlas',
                'location' => 'Head Office',
                'status' => 'Assigned',
                'purchase_date' => '2024-11-20',
                'warranty_expiry' => '2027-11-20',
                'remarks' => null,
            ],
            [
                'asset_tag' => 'ASI-PR-0001',
                'item_name' => 'Laser Printer',
                'category' => 'Printer',
                'brand' => 'Brother',
                'model' => 'HL-L2375DW',
                'serial_number' => 'BRL2375-0001',
                'assigned_to' => null,
                'department' => 'Administration',
                'campaign' => 'Office Upgrade',
                'location' => 'Head Office',
                'status' => 'Available',
                'purchase_date' => '2025-03-08',
                'warranty_expiry' => '2027-03-08',
                'remarks' => 'Shared department printer',
            ],
            [
                'asset_tag' => 'ASI-TB-0001',
                'item_name' => 'Android Tablet',
                'category' => 'Tablet',
                'brand' => 'Samsung',
                'model' => 'Galaxy Tab A9',
                'serial_number' => 'SMTA9-0001',
                'assigned_to' => 'Ana Cruz',
                'department' => 'Field Operations',
                'campaign' => 'Field Deployment',
                'location' => 'Branch Office',
                'status' => 'Assigned',
                'purchase_date' => '2025-05-12',
                'warranty_expiry' => '2027-05-12',
                'remarks' => 'For field reporting',
            ],
            [
                'asset_tag' => 'ASI-NW-0001',
                'item_name' => 'Network Switch',
                'category' => 'Networking',
                'brand' => 'TP-Link',
                'model' => 'TL-SG108',
                'serial_number' => 'TPLSG108-0001',
                'assigned_to' => null,
                'department' => 'IT',
                'campaign' => 'Network Refresh',
                'location' => 'Server Room',
                'status' => 'Under Maintenance',
                'purchase_date' => '2024-08-01',
                'warranty_expiry' => '2027-08-01',
                'remarks' => 'Pending port inspection',
            ],
        ];

        foreach ($items as $itemData) {
            $inventoryItem = InventoryItem::updateOrCreate(
                ['asset_tag' => $itemData['asset_tag']],
                array_merge($itemData, [
                    'history' => json_encode([]),
                    'file_attach' => json_encode([]),
                ])
            );

            $inventoryItem->campaignHistory()->firstOrCreate([
                'campaign' => $inventoryItem->campaign,
                'department' => $inventoryItem->department,
                'assigned_to' => $inventoryItem->assigned_to,
            ]);
        }
    }
}