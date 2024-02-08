<?php

namespace Tests\Feature;

use App\Http\Integrations\Punk\Requests\GetBeerRequest;
use App\Models\Beer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Tests\TestCase;

class SaveBeerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Config::preventStrayRequests();
    }

    /** @test */
    public function test_it_can_save_a_beer_and_food_pairings()
    {
        $user = User::factory()->create();

        MockClient::global([
            GetBeerRequest::class => MockResponse::fixture('beer'),
        ]);

        $this->actingAs($user)->post(route('beers.store', ['beer_id' => 210]));

        $this->assertCount(1, Beer::all());
        $this->assertCount(3, Beer::where('beer_id', 210)->first()->foodPairings()->get());
    }
}
