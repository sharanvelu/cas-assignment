<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $project->name }} : Integrations
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Hubspot Integration') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update your Hubspot's API key.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('projects.integrations.update', ['project' => $project]) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="api_key" :value="__('API Key')" />
                                <x-text-input id="api_key" name="api_key" type="text" class="mt-1 block w-full" :value="old('api_key', $projectIntegration?->value)" required autofocus autocomplete="api_key" />
                                <x-input-error class="mt-2" :messages="$errors->get('api_key')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('projects.show', ['project' => $project]) }}">
                    <x-secondary-button>
                        <i class="pr-2 fa-solid fa-arrow-left"></i>{{ __('Back to Project Detail') }}
                    </x-secondary-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
