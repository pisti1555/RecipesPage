<x-app-layout>
    <div class="container mx-0 p-6">
        <div class="flex">
            <div class="w-1/4 flex-shrink-0 p-4 border-r border-gray-200">
                <form method="GET" action="{{ route('recipes.index') }}" class="space-y-4">
                    <div>
                        <label for="orderby" class="block text-lg font-medium">Order by:</label>
                        <select name="orderby" id="orderby" class="border border-gray-300 rounded-lg p-2 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                            <option value="">Any</option>
                            <option value="created_at">Upload time</option>
                            <option value="rating">Rating</option>
                            <option value="difficulty">Difficulty</option>
                            <option value="name">Name</option>
                        </select>
                    </div>
                    <div>
                        <label for="direction" class="block text-lg font-medium">Direction:</label>
                        <select name="direction" id="direction" class="border border-gray-300 rounded-lg p-2 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                        Sort
                    </button>
                </form>
            </div>
            
            <div class="w-3/4 p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @forelse ($recipes as $recipe)
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="block border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow duration-300 bg-white transform hover:scale-105 transition-transform duration-300">
                        <div class="img-container">
                            <img src="/storage/{{ $recipe->image }}" class="rounded-t-lg w-full h-48 object-cover" />
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
                        <p class="text-center col-span-full">No recipes found</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
