<?php

namespace Tests\Unit;

use App\Models\InventoryItem;
use PHPUnit\Framework\TestCase;

class InventoryItemLocationTest extends TestCase
{
    public function test_item_detects_when_it_is_already_in_destination_location(): void
    {
        $item = new InventoryItem([
            'item_name' => 'Laptop',
            'location' => 'Warehouse A',
        ]);

        $this->assertTrue($item->isAlreadyAtLocation('warehouse a'));
        $this->assertFalse($item->isAlreadyAtLocation('Main Office'));
    }
}
