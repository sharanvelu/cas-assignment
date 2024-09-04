<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Project Detail') }}
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
                        <div class="py-2">
                            <x-input-label for="name" :value="__('Name')" />
                            <div class="text-sm mt-1 block w-full text-gray-900 dark:text-gray-100">{{ $project->name }}</div>
                        </div>
                        <div class="py-2">
                            <x-input-label for="name" :value="__('Url')" />
                            <div class="text-sm mt-1 block w-full text-gray-900 dark:text-gray-100">{{ $project->url }}</div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('projects.index') }}" class="ms-3 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="pr-2 fa-solid fa-arrow-left"></i> {{ __('Back to Projects') }}
                </a>

                <a href="{{ route('projects.edit', ['project' => $project]) }}" class="ms-3 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="pr-2 fa-solid fa-pen"></i> {{ __('Edit') }}
                </a>

                <!-- TODO: implement delete -->
                <x-danger-button class="ms-3">
                    <i class="pr-2 fa-solid fa-trash"></i> {{ __('Delete Project') }}
                </x-danger-button>
            </div>
        </div>
    </div>
</x-app-layout>
