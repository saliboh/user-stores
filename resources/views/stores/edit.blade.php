@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-xl font-semibold mb-4">Edit Store</h2>

            <form action="{{ route('stores.update', $store->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block font-semibold mb-1">Title:</label>
                    <input type="text" name="title" id="title" value="{{ $store->title }}" class="w-full rounded border px-4 py-2 focus:outline-none focus:border-blue-400">
                </div>

                <div class="mb-4">
                    <label for="description" class="block font-semibold mb-1">Description:</label>
                    <textarea name="description" id="description" rows="4" class="w-full rounded border px-4 py-2 focus:outline-none focus:border-blue-400">{{ $store->description }}</textarea>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">Update Store</button>
            </form>
        </div>
    </div>
@endsection
