<x-app-layout>
    <div class="container mx-auto mt-10">
        <div class="flex justify-center">
            <div class="w-full max-w-2xl">
                <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
                    <h2 class="text-3xl font-bold mb-5 text-center">Create a new recipe</h2>
                    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name of recipe:</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
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
                            <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                            <select id="category" name="category" value="{{ old('category') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="difficulty" class="block text-gray-700 text-sm font-bold mb-2">Difficulty (1-10):</label>
                            <input type="number" id="difficulty" name="difficulty" value="{{ old('difficulty') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="1" max="10">
                            @error('difficulty')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="time" class="block text-gray-700 text-sm font-bold mb-2">Time (in minutes):</label>
                            <input type="number" id="time" name="time" value="{{ old('time') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="1" max="500">
                            @error('time')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="ingredients" class="block text-gray-700 text-sm font-bold mb-2">Ingredients:</label>
                            <textarea id="ingredients" name="ingredients" rows="5"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('ingredients') }}</textarea>
                            @error('ingredients')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="instructions" class="block text-gray-700 text-sm font-bold mb-2">Instructions:</label>
                            <textarea id="instructions" name="instructions" rows="5"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('instructions') }}</textarea>
                            @error('instructions')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Save
                            </button>
                        </div>
                    </form>
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
