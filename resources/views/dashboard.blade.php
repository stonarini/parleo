<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-3">
                <div class="p-6 text-gray-900">
                    @if (count(Auth::user()->tokens) > 0)
                        API Token: {{ Auth::user()->tokens[0]->token }}
                    @else
                        Need an API Token?<br />
                        <form action="/tokens/create" method="post">
                            @csrf
                            <x-primary-button>Create API Token</x-primary-button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach (Auth::user()->communities()->get() as $com)
                @foreach ($com->community()->first()->posts()->get() as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-3">
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <div>
                                <p class="font-semibold text-md text-gray-600 leading-tight inline">
                                    /r/{{ $com->community()->first()->name }}
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
                @endforeach
            @endforeach
        </div>
    </div>
</x-app-layout>
