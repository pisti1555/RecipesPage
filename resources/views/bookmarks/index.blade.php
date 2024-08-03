<x-app-layout>
    <h1 class="m-10 text-2xl font-bold mb-4">Bookmarks</h1>
    <div class="container mx-auto">
        @forelse($bookmarks as $mark)
            <div class="flex justify-between border border-gray-300 rounded-lg shadow-sm mb-4 p-4">
                <div class="flex">
                    @if($mark->image)
                        <img src="{{ asset('storage/' . $mark->image) }}" alt="{{ $mark->name }}" class="w-32 h-32 object-cover rounded mb-2">
                    @endif
                    <div class="ml-5">
                        <h4 class="text-xl font-semibold mb-2">{{ $mark->name }}</h4>
                        <p class="text-gray-700 mb-2">Category: {{ $mark->category }}</p>
                        <div class="flex items-center justify-center">
                            <span class="mr-2">Rating:</span>
                            <span class="text-yellow-500 text-2xl">
                                @for ($i = 0; $i < $mark->getRating(); $i++)
                                    ★
                                @endfor
                                @for ($i = $mark->getRating(); $i < 5; $i++)
                                    ☆
                                @endfor
                            </span>
                            @if ($mark->getRating() == 0)
                                <p class="ml-2">( unrated )</p>
                            @else
                                <p class="ml-2">by {{ $mark->ratings->count() }} review</p>
                            @endif
                        </div>
                    </div>
                </div>
                <form action="{{ route('bookmarks.destroy', $mark->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Remove Bookmark
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-700">You have no bookmarked recipes</p>
        @endforelse
    </div>
</x-app-layout>
