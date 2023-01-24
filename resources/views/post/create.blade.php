<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            POST
        </h2>
        @if (!$post)
            <p class="inline text-sm text-gray-500">{{ __('post.create') }}</p>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex float-right sm:items-center inline">
                <x-dropdown align="right" width="100">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ $community->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @foreach ($userCommunities as $com)
                            <x-dropdown-link :href="route('post.edit', ['community' => $com->community()->first(), 'post' => null])">
                                {{ $com->community()->first()->name }}
                            </x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>
            </div>
        @else
            <p class="inline text-sm text-gray-500">{{ __('post.edit') }}</p>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('post.partials.information-form')
                </div>
            </div>
            @if ($post)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('post.partials.delete-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
