<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">
        
        <div class="flex mt-6 justify-between items-content">
            <h2 class="font-semibold text-xl">Edit Packaging</h2>
            @include('packagings.partials.delete-packaging')
        </div>
        
        <div class="mt-4" x-data="{ imageUrl: '/storage/{{ $packaging->foto }}' }">
            <form enctype="multipart/form-data" method="POST" action="{{ route('packagings.update', $packaging) }}" class="flex gap-8">
                @csrf
                @method('PUT')

                <div class="w-1/2">
                    <img :src="imageUrl" class="rounded-md"/>
                </div>

                <div class="w-1/2">
                <div class="mt-4">
                    <x-input-label for="foto" :value="__('Foto')" />
                    <x-text-input accept="image/*" id="foto" class="block mt-1 w-full border p-2" type="file" name="foto" :value="$packaging->foto" @change="imageUrl = URL.createObjectURL($event.target.files[0])" />
                    <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="nama" :value="__('Nama')" />
                    <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="$packaging->nama" required/>
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="harga" :value="__('Harga')" />
                    <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga" :value="$packaging->harga" x-mask:dynamic="$money($input, ',')" required/>
                    <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                    <x-text-area id="deskripsi" class="block mt-1 w-full" type="text" name="deskripsi">{{ $packaging->deskripsi }}</x-text-area>
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>
                
                <x-primary-button class="justify-center w-full mt-4">
                    {{ __('Submit') }}
                </x-primary-button>
                </div>

            </form>
        </div>
        
    </div>
</x-app-layout>
