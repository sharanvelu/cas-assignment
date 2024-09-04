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
        </div>
    </div>
</x-app-layout>
