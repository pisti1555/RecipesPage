<?php 

$isAuthorized = auth()->user() != null;
$client = $isAuthorized ? auth()->user() : null;
$own = $isAuthorized && $client->recipes->contains($recipe);
$rating = $recipe->getRating();
$reviewCount = $recipe->ratings()->count();
$user = $recipe->user;

?>

<x-app-layout>
    <div class="container mx-auto p-10 bg-white rounded-lg shadow-lg max-w-4xl mt-10">
        @if ($isAuthorized)
            @if ($own)
                <div class="flex justify-end mb-4">
                    <a href="{{ route('recipes.edit', $recipe->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 focus:outline-none focus:shadow-outline">
                        Edit Recipe
                    </a>
                </div>
            @else
                <div class="flex justify-end mb-4">
                    <a href="{{ route('recipes.rate', $recipe->id) }}" class="mr-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 focus:outline-none focus:shadow-outline">
                        Rate this recipe
                    </a>
                    @if ($bookmarked)
                        <form action="{{ route('bookmarks.destroy', $recipe->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 focus:outline-none focus:shadow-outline">
                                Remove Bookmark
                            </button>
                        </form>
                    @else
                        <form action="{{ route('bookmarks.store', $recipe->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 focus:outline-none focus:shadow-outline">
                                Bookmark
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        @endif
        
        <div class="mb-6">
            <p class="text-lg font-semibold text-gray-600">Created by: 
                @if($user)
                    <a href="{{ route('profile.show', $user->username) }}" class="text-blue-600 hover:underline">{{ $user->username }}</a>
                @else
                    <span class="text-gray-800">Unknown</span>
                @endif
            </p>
        </div>

        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6 text-gray-900">{{ $recipe->name }}</h1>
            <p class="text-lg md:text-xl font-semibold text-gray-600 mb-2">Category: <span class="text-gray-800">{{ $recipe->category }}</span></p>
            <p class="text-lg md:text-xl font-semibold text-gray-600 mb-2">Difficulty: <span class="text-gray-800">{{ $recipe->difficulty }}/10</span></p>
            <p class="text-lg md:text-xl font-semibold text-gray-600 mb-2">Time required: <span class="text-gray-800">{{ $recipe->time }} minutes</span></p>
        </div>

        <div class="my-8">
            <h3 class="text-2xl font-semibold mb-3 text-gray-800">Rating:</h3>
            @if ($rating == 0)
                <p class="text-gray-600">Be the first to rate this recipe!</p>
            @else
                <div class="flex items-center justify-center">
                    <span class="text-yellow-500 text-2xl">
                        @for ($i = 0; $i < $rating; $i++)
                            ★
                        @endfor
                        @for ($i = $rating; $i < 5; $i++)
                            ☆
                        @endfor
                    </span>
                    <span class="ml-2 text-gray-600 text-lg">({{ $rating }})</span>
                    <p class="text-lg ml-3 text-gray-600">by {{ $reviewCount }} reviews</p>
                </div>
            @endif
        </div>

        <div class="mb-8 flex justify-center">
            <img src="/storage/{{ $recipe->image }}" alt="{{ $recipe->name }}" class="rounded-lg shadow-lg max-w-full h-auto" />
        </div>

        <div class="mb-8 w-7/8 mx-auto">
            <h3 class="text-2xl font-semibold mb-3 text-gray-800 border-b-2 border-gray-300 pb-2">Ingredients</h3>
            @foreach (explode("\n", $recipe->ingredients) as $ingredient)
                @if (trim($ingredient) === '')
                    <br>
                @else
                    <p>{{ $ingredient }}</p>
                @endif
            @endforeach
        </div>

        <div class="w-7/8 mx-auto mb-8">
            <h3 class="text-2xl font-semibold mb-3 text-gray-800 border-b-2 border-gray-300 pb-2">Instructions</h3>
            @foreach (explode("\n", $recipe->instructions) as $instruction)
                @if (trim($instruction) === '')
                    <br>
                @else
                    <p>{{ $instruction }}</p>
                @endif
            @endforeach
        </div>
    </div>

    <div class="container mx-auto p-10 bg-white rounded-lg shadow-lg max-w-4xl mt-10">
        <h3 class="text-2xl font-semibold mb-6 text-gray-900">Reviews</h3>
        @forelse ($recipe->ratings as $rating)
            <div class="mb-4 p-4 bg-gray-50 rounded-lg shadow-md flex items-start">
                <div class="w-14 h-14 mr-4 flex-shrink-0">
                    @if($rating->user)
                        @if($rating->user->profile->image)
                            <img src="/storage/{{ $rating->user->profile->image }}" alt="{{ $rating->user->username }}" class="w-full h-full rounded-full object-cover border border-gray-300 shadow-lg">
                        @else
                            <svg class="w-full h-full rounded-full border border-gray-300 shadow-lg bg-gray-200" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.31 0-6 2.69-6 6v2h12v-2c0-3.31-2.69-6-6-6z"/>
                            </svg>
                        @endif
                    @else
                        <svg class="w-full h-full rounded-full border border-gray-300 shadow-lg bg-gray-200" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.31 0-6 2.69-6 6v2h12v-2c0-3.31-2.69-6-6-6z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    @if($rating->user)
                        <a href="{{ route('profile.show', $rating->user->username) }}" class="text-xl font-bold text-blue-600 hover:underline">{{ $rating->user->username }}</a>
                    @else
                        <span class="text-xl font-bold text-gray-800">Unknown</span>
                    @endif
                    <div class="flex items-center mt-1">
                        <span class="text-yellow-500 text-xl">
                            @for ($i = 0; $i < $rating->rating; $i++)
                                ★
                            @endfor
                            @for ($i = $rating->rating; $i < 5; $i++)
                                ☆
                            @endfor
                        </span>
                        <span class="ml-2 text-gray-600 text-lg">({{ $rating->rating }})</span>
                    </div>
                    <p class="mt-2 text-gray-700">{{ $rating->comment }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-600">No reviews yet. Be the first to review!</p>
        @endforelse
    </div>
    
</x-app-layout>
