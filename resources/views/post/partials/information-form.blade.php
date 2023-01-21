<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Post</h2>
    </header>


    <form method="POST" enctype="multipart/form-data"
        action="{{ route('post.save', ['community' => $community, 'post' => $post ?? null]) }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $post ? $post->title : '')"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>
        <script>
            function show(show, hide) {
                document.getElementById('cont-' + show).classList.remove('hidden');
                document.getElementById(show).required = true
                document.getElementById('tabs-' + show + '-tab').classList.add('bg-gray-100');
                document.getElementById('cont-' + hide).classList.add('hidden')
                document.getElementById(hide).required = false
                document.getElementById('tabs-' + hide + '-tab').classList.remove('bg-gray-100')
            }
        </script>
        <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4" id="tabs-tab"
            role="tablist">
            <li class="nav-item" role="presentation">
                <a onclick="show('text', 'image')"
                    class="nav-link block font-medium text-xs leading-tight uppercase border-x-0 border-t-0 border-b-2 border-transparent px-6 py-3 my-2 hover:border-transparent text-gray-500 hover:bg-gray-200 focus:border-transparent bg-gray-100"
                    id="tabs-text-tab" data-bs-toggle="pill" data-bs-target="#tabs-text" role="tab"
                    aria-controls="cont-text" aria-selected="true">
                    Text
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a onclick="show('image', 'text')"
                    class="nav-link block font-medium text-xs leading-tight uppercase border-x-0 border-t-0 border-b-2 border-transparent px-6 py-3 my-2 hover:border-transparent text-gray-500 hover:bg-gray-200 focus:border-transparent"
                    id="tabs-image-tab" data-bs-toggle="pill" data-bs-target="#tabs-image" role="tab"
                    aria-controls="cont-image" aria-selected="false">
                    Image
                </a>
            </li>
        </ul>
        <div class="tab-content" id="tabs-tabContent">
            <div class="tab-pane fade" id="cont-text" role="tabpanel" aria-labelledby="tabs-text-tab">
                <x-text-input id="text" name="text" type="text" class="mt-1 block w-full" :value="old('text', $post ? $post->content : '')"
                    required />
                <x-input-error class="mt-2" :messages="$errors->get('text')" />
            </div>
            <div class="tab-pane fade hidden" id="cont-image" role="tabpanel" aria-labelledby="tabs-image-tab">
                <x-text-input id="image" name="image" type="file" class="mt-1 block w-full"
                    :value="old('image')" />
                <x-input-error class="mt-2" :messages="$errors->get('image')" />
            </div>
        </div>

        <div class="mb-3 xl:w-96">
            <p class="block font-medium text-sm text-gray-700">Access</p>
            <select
                class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                name="access" required>
                <option {{ $post && $post->access == 'private' ? 'selected' : ($post ? '' : 'selected') }}
                    value="private">Private</option>
                <option {{ $post && $post->access == 'public' ? 'selected' : '' }} value="public">Public</option>
            </select>
        </div>

        <div class="mb-3 xl:w-96 flex">
            <x-input-label for="commentable" :value="__('Commentable')" />
            <x-text-input id="commentable" name="commentable" type="checkbox" class="mt-1 block m-2"
                checked="{{ old('commentable', $post ? $post->commentable : true) }}" value="true" />
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Post') }}</x-primary-button>
        </div>
    </form>
</section>
