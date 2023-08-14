<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveStoreRequest;
use App\Models\Store;
use App\Services\StoreService;
use Exception;

class StoreController extends Controller
{
    private const DEFAULT_PER_PAGE = 10;

    /**
     * @var StoreService
     */
    private $storeService;

    /**
     * @param StoreService $storeService
     */
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view(
            'stores.index',
            [
                'stores' => $this->storeService->getPaginated(self::DEFAULT_PER_PAGE),
            ]
        );
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('stores.create');
    }

    /**
     * @param SaveStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveStoreRequest $request)
    {
        try {
            $this->storeService->store($request->validated());

            return redirect()
                ->route('stores.index')
                ->with([
                    'success' => 'Store created successfully.',
                ]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(
                [
                    'failure' => 'Failed to create store. Please try again.',
                    'message' => $e->getMessage(),
                ]
            );
        }

    }

    /**
     * @param Store $store
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Store $store)
    {
        return view('stores.edit', compact('store'));
    }

    /**
     * @param Store $store
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Store $store)
    {
        return view('stores.edit', compact('store'));
    }

    /**
     * @param SaveStoreRequest $request
     * @param Store $store
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SaveStoreRequest $request, Store $store)
    {
        try {
            $this->storeService->update($store, $request->validated());

            return redirect()
                ->route('stores.index')
                ->with('success', 'Store updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(
                [
                    'message' => $e->getMessage(),
                ]
            );
        }

    }

    /**
     * @param Store $store
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Store $store)
    {
        try {
            $this->storeService->delete($store);

            return redirect()
                ->route('stores.index')
                ->with('success', 'Store deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(
                [
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
}
