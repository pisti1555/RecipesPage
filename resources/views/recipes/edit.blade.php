<x-app-layout>
    <div class="container mx-auto mt-10">
        <div class="flex justify-center">
            <div class="w-full max-w-2xl">
                <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
                    <h2 class="text-3xl font-bold mb-5 text-center">Edit Recipe</h2>
                    <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $recipe->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Select a new image:</label>
                            <div class="relative">
                                <input hidden type="file" name="image" id="image" class="absolute inset-0 opacity-0 cursor-pointer" onchange="updateUploadButton()">
                                <button type="button" onclick="document.getElementById('image').click()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full flex items-center justify-center">
                                    <span id="file-name" class="text-center">Choose a new image for your recipe</span>
                                </button>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" name="category" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" @if(old('category', $recipe->category) == $category) selected @endif>{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="difficulty" class="block text-gray-700 text-sm font-bold mb-2">Difficulty (1-10)</label>
                            <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="difficulty" name="difficulty" value="{{ old('difficulty', $recipe->difficulty) }}" required min="1" max="10">
                            @error('difficulty')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="time" class="block text-gray-700 text-sm font-bold mb-2">Time (in minutes)</label>
                            <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="time" name="time" value="{{ old('time', $recipe->time) }}" required min="1" max="500">
                            @error('time')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="ingredients" class="block text-gray-700 text-sm font-bold mb-2">Ingredients:</label>
                            <textarea name="ingredients" id="ingredients" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-96 resize-none">{{ old('ingredients', $recipe->ingredients) }}</textarea>
                            @error('ingredients')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="instructions" class="block text-gray-700 text-sm font-bold mb-2">Instructions:</label>
                            <textarea name="instructions" id="instructions" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-96 resize-none">{{ old('instructions', $recipe->instructions) }}</textarea>
                            @error('instructions')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update
                            </button>
                        </div>
                    </form>

                    <div class="mt-5">
                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-lg transform transition-transform duration-300 focus:outline-none focus:shadow-outline">
                                Delete Recipe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateUploadButton() {
            const input = document.getElementById('image');
            const name = input.files[0] ? input.files[0].name : 'Choose a file';
            document.getElementById('file-name').innerText = name;
        }
    </script>
</x-app-layout>
