<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Recipes</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($recipes as $recipe)
            <a href="{{ route('recipes.show', $recipe->id) }}" class="block border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow duration-300 bg-white transform hover:scale-110 transition-transform duration-300">
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
                <p>No recipes found</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
