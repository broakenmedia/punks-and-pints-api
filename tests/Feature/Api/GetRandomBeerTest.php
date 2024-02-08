<?php

namespace Tests\Feature\Api;

use App\Http\Integrations\Punk\Requests\GetRandomBeerRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Tests\TestCase;

class GetRandomBeerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::preventStrayRequests();
    }

    /** @test */
    public function test_it_can_retrieve_a_random_beer_successfully()
    {
        $user = User::factory()->create();

        MockClient::global([
            GetRandomBeerRequest::class => MockResponse::fixture('beer'),
        ]);

        $response = $this->actingAs($user)->getJson(route('beers.random'));

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $data = $response->json();
        $this->assertTrue($data['success']);
        $this->assertArrayHasKey('data', $data);
        $this->assertCount(1, $data['data']);
    }

    /** @test */
    public function test_it_handles_rate_limit_exceeded_error_gracefully()
    {
        MockClient::global([
            GetRandomBeerRequest::class => MockResponse::make(
                status: Response::HTTP_TOO_MANY_REQUESTS,
                headers: ['x-ratelimit-limit' => '60', 'x-ratelimit-remaining' => '0']
            ),
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('beers.random'))
            ->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);

        $data = $response->json();

        $this->assertFalse($data['success']);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data['data']);
    }
}
