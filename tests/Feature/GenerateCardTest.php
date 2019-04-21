<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GenerateCardTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function it_should_generate_card_number()
    {
        $response = $this->json('post', '/api/generate-card', [
            'amount' => 200,
            'type' => 'number',
        ]);

        $response->assertJsonFragment(['httpCode' => 200]);
    }
}
