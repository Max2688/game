<?php

namespace Services;

use App\Models\User;
use App\Services\GenerateLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateLinkTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testServiceGenerateLink()
    {
        $user = User::factory()->create();

        $generateLinkService = new GenerateLink();

        $this->actingAs($user);

        $uniqueLink = $generateLinkService->generateLink($user);

        $this->assertDatabaseHas('links', [
            'user_id' => $user->id,
            'unique_link' => $uniqueLink,
        ]);
    }
}
