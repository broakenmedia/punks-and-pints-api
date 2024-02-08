<?php

use App\Http\Integrations\Punk\Requests\GetBeersRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Tests\TestCase;

class GetBeersTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::preventStrayRequests();
    }

    /** @test */
    public function test_it_can_retrieve_a_list_of_beers_successfully()
    {
        $user = User::factory()->create();

        MockClient::global([
            GetBeersRequest::class => MockResponse::fixture('beers'),
        ]);

        $response = $this->actingAs($user)->getJson(route('beers.index'));

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $data = $response->json();
        $this->assertTrue($data['success']);
        $this->assertArrayHasKey('data', $data);
        $this->assertCount(25, $data['data']);
    }

    /** @test */
    public function test_it_returns_errors_when_fields_invalid()
    {
        $user = User::factory()->create();

        MockClient::global([
            GetBeersRequest::class => MockResponse::make(),
        ]);

        $invalidData = [
            'abv_gt' => 'not_numeric',
            'abv_lt' => 'not_numeric',
            'ibu_gt' => 'not_numeric',
            'ibu_lt' => 'not_numeric',
            'ebc_gt' => 'not_numeric',
            'ebc_lt' => 'not_numeric',
            'beer_name' => '',
            'yeast' => '',
            'brewed_before' => 'invalid_date_format',
            'brewed_after' => 'invalid_date_format',
            'hops' => '',
            'malt' => '',
            'food' => '',
            'page' => 'not_numeric',
            'per_page' => 'not_numeric',
        ];

        $response = $this->actingAs($user)->getJson(route('beers.index', $invalidData))
            ->assertJsonValidationErrors(array_keys($invalidData));

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $data = $response->json();

        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('errors', $data);
    }

    /** @test */
    public function test_it_handles_rate_limit_exceeded_error_gracefully()
    {
        MockClient::global([
            GetBeersRequest::class => MockResponse::make(
                status: Response::HTTP_TOO_MANY_REQUESTS,
                headers: ['x-ratelimit-limit' => '60', 'x-ratelimit-remaining' => '0']
            ),
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('beers.index'))
            ->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);

        $data = $response->json();

        $this->assertFalse($data['success']);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data['data']);
    }
}
