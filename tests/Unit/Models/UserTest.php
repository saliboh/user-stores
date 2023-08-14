<?php

namespace Tests\Unit\Models;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserTest extends TestCase
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
        $this->assertTrue(Schema::hasTable($this->user->getTable()));
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship related tests
    |--------------------------------------------------------------------------
    */
    /**
     * @test
     */
    public function checkIfrStoresRelationIsOk()
    {
        $this->assertInstanceOf(HasMany::class, $this->user->rStores());
        $this->assertInstanceOf(Collection::class, $this->user->rStores);
        $this->assertInstanceOf(Store::class, $this->user->rStores->first());
        $this->assertEquals($this->store->id, $this->user->rStores->first()->id);
    }
}
