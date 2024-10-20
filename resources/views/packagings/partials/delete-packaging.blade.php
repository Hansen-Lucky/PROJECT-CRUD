<section class="space-y-6">

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-packaging')"
    >{{ __('Delete Packaging') }}</x-danger-button>

    <x-modal name="confirm-delete-packaging" focusable>
        <form method="post" action="{{ route('packagings.destroy', $packaging) }}" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your packaging?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your packaging is deleted, all of its resources and data will be permanently deleted.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Packaging') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
