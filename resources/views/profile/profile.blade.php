<?php 
    $isAuthorized = auth()->user() != null;
    $client = $isAuthorized ? auth()->user() : null;
?>

<x-app-layout>
    <div class="container mx-auto mt-2 mb-2">
        <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl font-bold mb-5 text-center text-gray-900">Profile</h2>

            @if ($client == $user)
                <div class="flex items-center justify-end mb-4">
                    <a href="{{ route('profile.edit') }}" class="mr-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                        Edit Profile
                    </a>
                    <a href="{{ route('recipes.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                        Create a new recipe
                    </a>
                </div>
            @endif

            <div class="flex mb-4">
                <div class="mr-6">
                    @if($profile->image)
                        <img src="/storage/{{ $profile->image }}" class="w-48 h-48 rounded-full object-cover border border-gray-300 shadow-lg">
                    @else
                        <svg class="w-48 h-48 rounded-full border border-gray-300 shadow-lg bg-gray-200" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.31 0-6 2.69-6 6v2h12v-2c0-3.31-2.69-6-6-6z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                        <p class="text-gray-900">{{ $user->username }}</p>
                    </div>

                    @if ($profile->show_name)
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                            <p class="text-gray-900">{{ $user->name }}</p>
                        </div>
                    @endif

                    @if ($profile->show_email)
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">E-Mail:</label>
                            <p class="text-gray-900">{{ $user->email }}</p>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Joined:</label>
                        <p class="text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="font-semibold text-gray-800">Recipes created: {{ $user->recipes->count() }}</p>
                        @if ($profile->description)
                            <p class="text-gray-700">Description: {{ $profile->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-2xl font-bold mb-4">Recipes</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse ($recipes as $recipe)
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="block border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow duration-300 bg-white transform hover:scale-105 transition-transform duration-300">
                        <div class="img-container">
                            <img src="{{ '/storage/' . $recipe->image }}" alt="{{ $recipe->name }}" class="rounded-t-lg w-full h-48 object-cover" />
                        </div>
                        <div class="p-4 flex justify-between">
                            <h1 class="text-xl font-semibold text-gray-900">{{ $recipe->name }}</h1>
                            <div>
                                <div class="flex items-center">
                                    <span class="text-yellow-500 text-xl">
                                        @for ($i = 0; $i < $recipe->getRating(); $i++)
                                            ★
                                        @endfor
                                        @for ($i = $recipe->getRating(); $i < 5; $i++)
                                            ☆
                                        @endfor
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-600">No recipes uploaded</p>
                @endforelse
            </div>
        </div>

        <div class="mt-10">
            <h2 class="text-2xl font-bold mb-4">Reviews</h2>
            <div class="grid grid-cols-1 gap-6">
                @forelse ($user->ratings as $rating)
                    <a href=" {{ route('recipes.show', $rating->recipe->id) }} " class="block p-4 bg-gray-100 rounded-lg shadow-md hover:bg-gray-200 transition duration-300">
                        <div class="flex items-center">
                            <img src="/storage/{{ $rating->recipe->image }}" alt="{{ $rating->recipe->name }}" class="w-16 h-16 rounded-full mr-4 object-cover">
                            <div>
                                <h4 class="text-xl font-bold text-gray-800">{{ $rating->recipe->name }}</h4>
                                <div class="flex items-center">
                                    <span class="text-yellow-500">
                                        @for ($i = 0; $i < $rating->rating; $i++)
                                            ★
                                        @endfor
                                        @for ($i = $rating->rating; $i < 5; $i++)
                                            ☆
                                        @endfor
                                    </span>
                                    <span class="ml-2 text-gray-600">({{ $rating->rating }})</span>
                                </div>
                            </div>
                        </div>
                        <p class="mt-2 text-gray-700">{{ $rating->comment }}</p>
                    </a>
                @empty
                    <p class="text-gray-600">No reviews made by this user</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
