<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Projects') }}
            <div class="float-right">
                <a href="{{ route('projects.create') }}" class="items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <i class="mr-2 fa-solid fa-plus"></i> Create Project
                </a>
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-3 gap-4">
            @foreach($projects as $project)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 ">
                        <a href="{{ $project->url }}" target="_blank">
                            {{ $project->name }}
                            <span class="float-right">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </span>
                        </a>
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-3 gap-2">
                        <a href="{{ route('projects.show', ['project' => $project]) }}">
                            <x-secondary-button>
                                <i class="pr-2 fa-solid fa-eye"></i>{{ __('View') }}
                            </x-secondary-button>
                        </a>

                        <a href="{{ route('projects.edit', ['project' => $project]) }}">
                            <x-secondary-button>
                                <i class="pr-2 fa-solid fa-pen"></i>{{ __('Edit') }}
                            </x-secondary-button>
                        </a>

                        <form action="{{ route('projects.destroy', ['project' => $project]) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <x-danger-button onclick="event.preventDefault(); if (window.confirm('Are you sure to delete this?')) {this.closest('form').submit();}">
                                <i class="pr-2 fa-solid fa-trash"></i> {{ __('Delete') }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
