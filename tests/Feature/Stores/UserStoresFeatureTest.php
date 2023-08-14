<?php

namespace Tests\Unit\Models;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserStoresFeatureTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * @var User $user
     */
    private $user;

    /**
     * @var Store $store
     */
    private $store;

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->store = Store::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function userCanSeeOwnedStores(): void
    {
        $url = route('stores.index');

        $result = $this->call('GET', $url);

        $result
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('stores.index')
            ->assertViewHas('stores');
    }

    /**
     * @test
     */
    public function userCreateAStore(): void
    {
        $data = [
            'title' => 'Title',
            'description' => $this->faker->sentence(3),
        ];

        $url = route('stores.store');
        $result = $this->call('POST', $url, $data);

        $result
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect(route('stores.index'))
            ->assertSessionDoesntHaveErrors([
                'failure',
                'message',
            ]);

        $expectedCount = 2;
        $this->assertEquals($expectedCount, Store::all()->count());
    }

    /**
     * @test
     */
    public function userCanUpdateAStore(): void
    {
        $data = [
            'title' => 'Edited',
            'description' => 'Edited',
        ];

        $url = route('stores.update', ['store' => $this->store->id]);
        $result = $this->call('PUT', $url, $data);

        $result
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect(route('stores.index'))
            ->assertSessionDoesntHaveErrors([
                'message',
            ]);

        $this->store->refresh();
        $expectedCount = 1;
        $this->assertEquals($expectedCount, Store::all()->count());
        $this->assertEquals($data['title'], $this->store->title);
        $this->assertEquals($data['description'], $this->store->description);
    }

    /**
     * @test
     */
    public function userCanViewASpecificStore(): void
    {
        $url = route('stores.show', ['store' => $this->store->id]);
        $result = $this->call('GET', $url);

        $result
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('stores.edit')
            ->assertViewHas('store');
    }

    /**
     * @test
     */
    public function userCanDeleteAStore(): void
    {
        $url = route('stores.destroy', ['store' => $this->store->id]);
        $result = $this->call('DELETE', $url);

        $result
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect(route('stores.index'))
            ->assertSessionDoesntHaveErrors([
                'message',
            ]);
    }
}
