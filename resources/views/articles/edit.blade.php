<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('articles.update', ['project' => $project, 'article' => $article]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('articles.partials.article')
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('articles.partials.meta')
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('articles.partials.featured_image')
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <div class="flex items-center gap-4">
                            <a href="{{ route('articles.index', ['project' => $project]) }}">
                                <x-secondary-button>{{ __('Cancel') }}</x-secondary-button>
                            </a>
                            <x-primary-button>{{ __('Update Article') }}</x-primary-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
