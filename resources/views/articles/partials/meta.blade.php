<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Meta Information') }}
        </h2>
    </header>

    <div>
        <x-input-label for="meta_title" :value="__('Title')"/>
        <x-text-input id="meta_title" name="meta_title" type="text" class="mt-1 block w-full" required
                      autocomplete="meta_title" value="{{ old('meta_title', optional($article ?? null)->meta_title ?? '') }}"/>
        <x-input-error class="mt-2" :messages="$errors->get('meta_title')"/>
    </div>

    <div>
        <x-input-label for="meta_description" :value="__('Content')"/>
        <x-text-input id="meta_description" name="meta_description" type="text" class="mt-1 block w-full" required autocomplete="meta_description"
                      value="{{ old('meta_description', optional($article ?? null)->meta_description ?? '') }}"/>
        <x-input-error class="mt-2" :messages="$errors->get('meta_description')"/>
    </div>
</section>
