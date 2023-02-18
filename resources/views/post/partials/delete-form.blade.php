<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">{{ __('post.delete') }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ __('post.delete_warning_1') }} {{ __('post.delete_warning_2') }}</p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('post.delete') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('post.destroy', ['community' => $community->name, 'post' => $post]) }}"
            class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">{{ __('post.delete_confirmation') }}</h2>
            <p class="mt-1 text-sm text-gray-600">{{ __('post.delete_warning_1') }}</p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('post.cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('post.delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
