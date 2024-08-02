<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" enctype="multipart/form-data" action="{{ route('profile.update-info') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" id="image" name="image" value="{{ old('image') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('image')
                <div class="mt-1 text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $profile->description)" autofocus autocomplete="description" />
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div class="flex items-center space-x-4">
            <label for="show_email" class="flex items-center space-x-2">
                <span class="text-sm font-medium text-gray-700">Show e-mail on profile</span>
                <input type="hidden" name="show_email" value="0">
                <input type="checkbox" id="show_email" name="show_email" value="1" {{ old('show_email', $profile->show_email) ? 'checked' : '' }}
                    class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </label>
            @error('show_email')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center space-x-4">
            <label for="show_name" class="flex items-center space-x-2">
                <span class="text-sm font-medium text-gray-700">Show name on profile</span>
                <input type="hidden" name="show_name" value="0">
                <input type="checkbox" id="show_name" name="show_name" value="1" {{ old('show_name', $profile->show_name) ? 'checked' : '' }}
                    class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </label>
            @error('show_name')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>