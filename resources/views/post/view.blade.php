<x-app-layout>
    <x-slot name="header">
        <div class="py-12">
            <div class="max-w-7xl mx-auto lg:px-8">
                @can('update', $post)
                    <form method="post" class="pb-1"
                        action="{{ route('post.update', ['community' => $community, 'post' => $post]) }}">
                        @csrf
                        @method('put')
                        <x-primary-button>
                            {{ __('post.edit_button') }}
                        </x-primary-button>
                    </form>
                @endcan
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div>
                        <p class="font-semibold text-md text-gray-600 leading-tight inline"> /r/{{ $community->name }}
                        </p>
                        <p class="text-sm text-gray-400 leading-tight inline"> - {{ __('post.posted') }}
                            /u/{{ $post->user()->first()->name }} {{ $post->date }}</p>
                        <h1 class="font-semibold text-gray-800 leading-tight mt-3" style="font-size: 1.75em">
                            {{ $post->title }}
                        </h1>
                        <div>
                            @if ($post->content)
                                <p class="text-xl text-gray-700 leading-tight">
                                    {{ $post->content }}
                                </p>
                            @else
                                <img src="{{ $post->image }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
