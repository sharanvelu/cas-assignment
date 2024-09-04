<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Images') }}
        </h2>
    </header>

    <div>
        <x-input-label for="featured_image" :value="__('Title')"/>
        <input type="file" id="featured_image" name="featured_image" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
        <x-input-error class="mt-2" :messages="$errors->get('featured_image')"/>
    </div>

</section>
