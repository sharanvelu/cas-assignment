<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $project->name }} : Articles
            <div class="float-right">
                <a href="{{ route('articles.create', ['project' => $project]) }}" class="items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Create Article
                </a>
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-3 gap-4">
            @foreach($articles as $article)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- todo: implement featured image -->
                    @if($article->title)
                        <div class="font-semibold p-6 text-gray-900 dark:text-gray-100">
                            {{ $article->title }}
                        </div>
                    @endif
                    <div class="px-6 text-green-600 dark:text-gray-200">
                        {!! substr($article->content, 0, 100) !!} {{ strlen($article->content) > 100 ? '...' : '' }}
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-3 gap-2">

                        <a href="{{ route('articles.show', ['project' => $project, 'article' => $article]) }}">
                            <x-secondary-button>
                                <i class="pr-2 fa-solid fa-eye"></i>{{ __('View') }}
                            </x-secondary-button>
                        </a>

                        <a href="{{ route('articles.edit', ['project' => $project, 'article' => $article]) }}">
                            <x-secondary-button>
                                <i class="pr-2 fa-solid fa-pen"></i>{{ __('Edit') }}
                            </x-secondary-button>
                        </a>

                        <!-- TODO: implement delete -->
                        <x-danger-button class="">
                            <i class="pr-2 fa-solid fa-trash"></i> {{ __('Delete') }}
                        </x-danger-button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
