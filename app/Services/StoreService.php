<?php

namespace App\Services;

use App\Models\Store;

class StoreService
{
    /**
     * @param int $per_page
     * @return mixed
     */
    public function getPaginated(int $per_page)
    {
        return Store::where('user_id', auth()->id())->paginate($per_page);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        $user = auth()->user();

        $user->rStores()->create($data);

        return $user->rStores->first();
    }

    /**
     * @param Store $store
     * @param array $data
     * @return mixed
     */
    public function update(Store $store, array $data)
    {
        $store->update($data);

        return $store->refresh();
    }

    /**
     * @param Store $store
     * @return bool|null
     */
    public function delete(Store $store)
    {
        return $store->delete();
    }
}
