<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto ">
        <div class="flex justify-center">
        @auth
    <button  onclick="window.location='{{ route('create') }}'" class=" text-white rounded-full py-2 px-5 text-lg font-semibold bg-lime-500 inline-block border border-lime-600 mr-3">
        Zutat hinzufügen
    </button>
    @endauth
        </div>
    </div>
    <div class="flex justify-center py-12">
        <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden sm:rounded-lg">
                <div class="py-5">
                    <button onclick="window.location='{{ route('showBottleSizes') }}'" class=" text-white rounded-full py-2 px-5 text-lg font-semibold bg-lime-500 inline-block border border-lime-600 mr-3">Beginne mit der Zusammenstellung</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
