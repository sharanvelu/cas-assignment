<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $project->name }} : Article Detail
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Project Information') }}
                            </h2>
                        </header>
                        <img src="{{ $article->featured_image }}" alt="{{ $article->featured_image }}">
                        <div class="py-2">
                            <x-input-label :value="__('Title')" />
                            <div class="text-sm mt-1 block w-full text-gray-900 dark:text-gray-100">{{ $article->title }}</div>
                        </div>
                        <div class="py-2">
                            <x-input-label :value="__('Content')" />
                            <div class="text-sm mt-1 block w-full text-gray-900 dark:text-gray-100">{{ $article->content }}</div>
                        </div>
                        <div class="py-2">
                            <x-input-label :value="__('Status')" />
                            <div class="text-sm mt-1 block w-full text-gray-900 dark:text-gray-100">{{ $article->status }}</div>
                        </div>
                        <div class="py-2">
                            <x-input-label :value="__('Meta Title')" />
                            <div class="text-sm mt-1 block w-full text-gray-900 dark:text-gray-100">{{ $article->meta_title ?? '-' }}</div>
                        </div>
                        <div class="py-2">
                            <x-input-label :value="__('Meta Description')" />
                            <div class="text-sm mt-1 block w-full text-gray-900 dark:text-gray-100">{{ $article->meta_description ?? '-' }}</div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('articles.index', ['project' => $project]) }}" class="ms-3 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="pr-2 fa-solid fa-arrow-left"></i> {{ __('Back to Articles') }}
                </a>

                <a href="{{ route('articles.edit', ['project' => $project, 'article' => $article]) }}" class="ms-3 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="pr-2 fa-solid fa-pen"></i> {{ __('Edit') }}
                </a>

                <!-- TODO: implement delete -->
                <x-danger-button class="ms-3">
                    <i class="pr-2 fa-solid fa-trash"></i> {{ __('Delete Article') }}
                </x-danger-button>
            </div>
        </div>
    </div>
</x-app-layout>
