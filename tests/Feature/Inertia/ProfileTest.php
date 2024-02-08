<?php

namespace Tests\Feature\Inertia;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function test_inertia_component_renders_for_route()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertInertia(
            fn (Assert $page) => $page->component('Profile/Edit')
        );
    }

    /** @test */
    public function test_will_pass_existing_api_tokens()
    {
        $user = User::factory()->create();
        $user->createToken('test');

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertInertia(
            fn (Assert $page) => $page->component('Profile/Edit')->has('existingApiTokens', 1)
        );
    }
}
