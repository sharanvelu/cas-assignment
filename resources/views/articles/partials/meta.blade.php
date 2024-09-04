<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Meta Information') }}
        </h2>
    </header>

    <div>
        <x-input-label for="meta_description" :value="__('Meta Description')"/>
        <x-text-input id="meta_description" name="meta_description" type="text" class="mt-1 block w-full" required autocomplete="meta_description"
                      value="{{ old('meta_description', optional($article ?? null)->meta_description ?? '') }}"/>
        <x-input-error class="mt-2" :messages="$errors->get('meta_description')"/>
    </div>
</section>
