@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-xl font-semibold mb-4">Create New Store</h2>

            @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-red-500">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('stores.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block font-semibold mb-1">Title:</label>
                    <input type="text" name="title" id="title" class="w-full rounded border px-4 py-2 focus:outline-none focus:border-blue-400">
                </div>

                <div class="mb-4">
                    <label for="description" class="block font-semibold mb-1">Description:</label>
                    <textarea name="description" id="description" rows="4" class="w-full rounded border px-4 py-2 focus:outline-none focus:border-blue-400"></textarea>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">Create Store</button>
            </form>
        </div>
    </div>
@endsection