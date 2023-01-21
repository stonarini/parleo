<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">Delete Post</h2>
        <p class="mt-1 text-sm text-gray-600">Once your post is deleted, all of its data will be permanently deleted.
            Before deleting your post, please download any data or information that you wish to retain.</p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">Delete
        Post</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('post.delete', ['community' => $community->name, 'post' => $post]) }}"
            class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">Are you sure your want to delete your post?</h2>
            <p class="mt-1 text-sm text-gray-600">Once your post is deleted, all of its data will be permanently
                deleted.</p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Post') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
