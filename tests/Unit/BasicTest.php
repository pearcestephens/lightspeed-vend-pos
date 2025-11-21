<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    public function test_basic_assertion(): void
    {
        $this->assertTrue(true);
    }
    
    public function test_environment_loaded(): void
    {
        $this->assertNotEmpty(php_uname());
    }
}
