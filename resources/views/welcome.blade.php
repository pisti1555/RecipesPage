<x-app-layout>
    <div class="container mx-auto mt-10">
        <div class="flex justify-center">
            <div class="w-full max-w-2xl">
                <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
                    <h1 class="text-4xl font-bold mb-5 text-center text-blue-700">Welcome</h1>
                    <p class="text-gray-700 text-lg text-center mb-5">You are now logged in!</p>
                    <p class="text-gray-700 text-lg text-center mb-5">Feel free to explore our website!</p>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('recipes.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full block text-center">
                        Browse recipes
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>