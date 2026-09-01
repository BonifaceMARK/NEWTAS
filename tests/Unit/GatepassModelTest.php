<?php

namespace Tests\Unit;

use App\Models\Gatepass;
use PHPUnit\Framework\TestCase;

class GatepassModelTest extends TestCase
{
    public function test_gatepass_model_exists(): void
    {
        $this->assertTrue(class_exists(Gatepass::class));
    }
}
