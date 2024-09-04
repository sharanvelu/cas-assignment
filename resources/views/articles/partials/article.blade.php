<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Article Information') }}
        </h2>
    </header>

    <div>
        <x-input-label for="title" :value="__('Title')"/>
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus
                      autocomplete="title" value="{{ old('title', optional($article ?? null)->title ?? '') }}"/>
        <x-input-error class="mt-2" :messages="$errors->get('title')"/>
    </div>

    <div>
        <x-input-label for="content" :value="__('Content')"/>
        <input type="text" hidden name="content" id="content" class="hidden">
        <div id="content_rte">{!! old('content', optional($article ?? null)->content ?? '') !!}</div>
        <x-input-error class="mt-2" :messages="$errors->get('content')"/>
    </div>
</section>

@push('styles')
    <link rel="stylesheet" href="{{ asset('richtexteditor/rte_theme_default.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('richtexteditor/rte.js') }}"></script>
    <script src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>

    <script>
        let editor = new RichTextEditor('#content_rte');

        let submitForm = () => {
            document.getElementById('content').value = editor.getHTMLCode()
            document.getElementById('article_form').submit();
        }
    </script>
@endpush
