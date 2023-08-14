<?php

namespace Tests\Unit\Services;

use App\Models\Store;
use App\Models\User;
use App\Services\StoreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class StoreServiceTest extends TestCase
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
     * @var StoreService $storeService
     */
    private $storeService;

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->storeService = app()->make(StoreService::class);
        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function indexReturnsData(): void
    {
        $this->artisan('db:seed --class=StoreSeeder');

        $result = $this->storeService->getPaginated(10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertInstanceOf(Store::class, $result->first());
    }

    /**
     * @test
     */
    public function storeIsSuccessful(): void
    {
        $data = [
            'title' => 'Title',
            'description' => $this->faker->sentence(3),
        ];

        $expectedTotal = Store::all()->count() + 1;
        $result = $this->storeService->store($data);

        $this->assertInstanceOf(Store::class, $result);
        $this->assertEquals($expectedTotal, Store::all()->count());
    }

    /**
     * @test
     */
    public function updateIsSuccessful(): void
    {
        $this->artisan('db:seed --class=StoreSeeder');

        $data = [
            'title' => 'Title modified',
            'description' => 'modified description',
        ];

        $expectedTotal = Store::all()->count();
        $store = Store::get()->first();

        $result = $this->storeService->update($store, $data);

        $this->assertInstanceOf(Store::class, $result);
        $this->assertEquals($expectedTotal, Store::all()->count());
        $this->assertEquals($data['title'], $result->title);
        $this->assertEquals($data['description'], $result->description);
    }

    /**
     * @test
     */
    public function deleteIsSuccessful(): void
    {
        $this->artisan('db:seed --class=StoreSeeder');

        $expectedTotal = Store::all()->count() - 1;
        $store = Store::get()->first();

        $result = $this->storeService->delete($store);

        $this->assertEquals($expectedTotal, Store::all()->count());
        $this->assertTrue($result);
    }
}
