<?php

namespace Tests\Feature\Api;

use App\Http\Integrations\Punk\Requests\GetBeerRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Tests\TestCase;

class GetBeerTest extends TestCase
{
    /** @test */
    public function test_it_can_retrieve_a_single_beer_by_id_successfully()
    {
        $user = User::factory()->create();

        $beerId = 1;

        $response = $this->actingAs($user)->getJson(route('beers.show', $beerId));

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $data = $response->json();
        $this->assertTrue($data['success']);
        $this->assertArrayHasKey('data', $data);
        $this->assertCount(1, $data['data']);
    }

    /** @test */
    public function test_it_returns_error_when_beer_id_is_not_a_number()
    {
        $user = User::factory()->create();

        $invalidBeerId = 'abc';

        $response = $this->actingAs($user)->getJson(route('beers.show', $invalidBeerId));

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $data = $response->json();
        $this->assertEquals('The beer id field must be a number.', $data['message']);
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('beerId', $data['errors']);
        $this->assertContains('The beer id field must be a number.', $data['errors']['beerId']);
    }

    /** @test */
    public function test_it_handles_rate_limit_exceeded_error_gracefully()
    {
        MockClient::global([
            GetBeerRequest::class => MockResponse::make(
                status: Response::HTTP_TOO_MANY_REQUESTS,
                headers: ['x-ratelimit-limit' => '60', 'x-ratelimit-remaining' => '0']
            ),
        ]);

        $user = User::factory()->create();

        $beerId = 1;

        $response = $this->actingAs($user)->getJson(route('beers.show', $beerId))
            ->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);

        $data = $response->json();

        $this->assertFalse($data['success']);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data['data']);
    }
}
