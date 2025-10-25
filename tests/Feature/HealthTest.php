<?php

namespace Tests\Feature;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class HealthTest extends TestCase
{
    #[Test]
    public function homepage_loads(): void
    {
        // basic smoke: app boots & homepage returns 200
        $this->get('/')->assertOk(); // == assertStatus(200)
    }
}
