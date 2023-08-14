<?php

namespace Tests\Unit\Models;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StoreTest extends TestCase
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
    }

    /**
     * @test
     */
    public function checkIfUsersTableExists(): void
    {
        $this->assertTrue(Schema::hasTable($this->store->getTable()));
    }
}
