@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-xl font-semibold mb-8">Stores</h2>

            <a href="{{ route('stores.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none mb-10 mt-15">Create New Store</a>

            <table class="w-full mt-8">
                <thead>
                <tr>
                    <th class="text-left py-2">Title</th>
                    <th class="text-left py-2">Description</th>
                    <th class="text-left py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stores as $store)
                    <tr>
                        <td class="py-2">{{ $store->title }}</td>
                        <td class="py-2">{{ $store->description }}</td>
                        <td class="py-2">
                            <a href="{{ route('stores.edit', $store->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('stores.destroy', $store->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Are you sure you want to delete this store?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $stores->links() }}
            </div>
        </div>
    </div>
@endsection
