<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">eview Recipe</h2>
    </x-slot>

    <?php 
        $review = $recipe->ratings->where('user_id', auth()->user()->id)->first();

        $rating = $review ? $review->rating : '';
        $comment = $review ? $review->comment : '';
    ?>
    
        
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8">
                <form method="POST" action="{{ route('recipes.rate.update', $recipe->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-6">
                        <label for="rating" class="block text-lg font-medium text-gray-700">Rating : between 1 and 5 stars</label>
                        <input id="rating" type="number" name="rating" min="1" max="5" required autofocus
                            class="block mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3"
                            placeholder="Rate this recipe"
                            value={{ old('rating', $rating) }}
                        />
                        @error('rating')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    

                    <div class="mb-6">
                        <label for="comment" class="block text-lg font-medium text-gray-700">Comment</label>
                        <textarea id="comment" 
                        class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                        name="comment" rows="6" placeholder="Tell your experiences and opinion">{{ old('comment', $comment) }}</textarea>
                        @error('comment')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 transition">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
