<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_endpoint_is_available(): void
    {
        $this->seed();

        $this->getJson('/api/public/home')
            ->assertOk()
            ->assertJsonStructure(['services','projects','testimonials','posts','settings']);
    }
}
