<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $project->name }} : Article Detail
            @if($article->status == \App\Models\Article::DRAFT)
                <div class="float-right">
                    <form method="post" action="{{ route('articles.publish', ['project' => $project, 'article' => $article]) }}">
                        @csrf

                        <x-primary-button>
                            Publish Article
                        </x-primary-button>
                    </form>
                </div>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Article Information') }}
                    </h2>
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-gray-700 dark:text-gray-300 font-bold">Title</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $article->title }}
                            </p>
                        </div>
                        <div>
                            <h2 class="text-gray-700 dark:text-gray-300 font-bold">Status</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {!! getStatusBadge($article->status) !!}
                            </p>
                        </div>
                        <div>
                            <h2 class="text-gray-700 dark:text-gray-300 font-bold">Featured Image</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                <img src="{{ retrieveFile($article->featured_image) }}" alt="Featured Image" class="max-w-lg">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Content') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
{{--                        {!! $article->content !!}--}}
                        {{ $article->content }}
                    </p>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Meta Information') }}
                    </h2>
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-gray-700 dark:text-gray-300 font-bold">Meta Title</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $article->meta_title }}
                            </p>
                        </div>
                        <div>
                            <h2 class="text-gray-700 dark:text-gray-300 font-bold">Meta Description</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $article->meta_description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mt-6 flex justify-end">
                <a href="{{ route('articles.index', ['project' => $project]) }}" class="ms-3 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="mr-3 fa-solid fa-arrow-left"></i> {{ __('Back to Articles') }}
                </a>

                <a href="{{ route('articles.edit', ['project' => $project, 'article' => $article]) }}" class="ms-3 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="pr-2 fa-solid fa-pen"></i> {{ __('Edit') }}
                </a>

                <form action="{{ route('articles.destroy', ['project' => $project, 'article' => $article]) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <x-danger-button class="ms-3" onclick="event.preventDefault(); if (window.confirm('Are you sure to delete this?')) {this.closest('form').submit();}">
                        <i class="pr-2 fa-solid fa-trash"></i> {{ __('Delete Article') }}
                    </x-danger-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
