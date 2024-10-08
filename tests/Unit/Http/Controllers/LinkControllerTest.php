<?php

namespace Http\Controllers;

use App\Http\Controllers\LinkController;
use App\Models\User;
use App\Services\Game\GenerateLinkInterface;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class LinkControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGenerateLinkInController()
    {
        $linkServiceMock = Mockery::mock(GenerateLinkInterface::class);

        $user = User::factory()->create();

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $linkServiceMock->shouldReceive('generateLink')
            ->once()
            ->with($user)
            ->andReturn('tSZd3ISdqcGeUDitmd9r4ByNWkU4XpEv');

        $controller = new LinkController($linkServiceMock);

        $response = $controller->generateLink();

        $this->assertTrue($response->getStatusCode() === 200);

        $responseData = $response->getData(true);
        $this->assertArrayHasKey('unique_link', $responseData);
        $this->assertEquals('tSZd3ISdqcGeUDitmd9r4ByNWkU4XpEv', $responseData['unique_link']);
    }
}
