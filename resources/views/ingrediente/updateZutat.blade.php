<x-app-layout>
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
                <div class="relative py-3 sm:max-w-xl sm:mx-auto">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-lime-400 to-lime-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl w-40em">
                    </div>
                    <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 w-40em">
                        <div class="max-w-md mx-auto">
                            <div>
                                <h1 class="text-2xl font-semibold">Zutat {{ $zutat['name'] }} aktualisieren:</h1>
                            </div>
                            <div class="divide-y divide-gray-200">
                                <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                                <form action="/updated/ingrediente/{{ $zutat['id'] }}" enctype="multipart/form-data" method="post">
                                  @csrf

                                    <div>
                                       <x-jet-label for="name" value="{{ __('Neuer Name:') }}" />
                                        <input class="block mt-1 w-full" id="name"  value="{{ old('name') ?? $zutat['name'] }}" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required  autofocus />
                                        @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="mt-4">
                                      <x-jet-label for="price" value="{{ __('Neuer Einzelpreis:') }}" />
                                        <input class="block mt-1 w-full" id="price" type="number" value="{{ old('price') ?? $zutat['price'] }}" step="0.01" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" required  autofocus />
                                        @if ($errors->has('price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-4">
                                      <x-jet-label for="type" value="{{ __('Neuer Type:') }}" />
                                        <select class="block mt-1 w-full" name="type" value="{{ old('type') ?? $zutat['type'] }}" required autofocus>
                                            <option value="fruits">fruits</option>
                                            <option value="vegetables">vegetables</option>
                                            <option value="liquid">liquid</option>
                                        </select>
                                    </div>
                                    <div class="mt-4">
                                      <x-jet-label for="image" value="{{ __('Neues SVG der Zutat:') }}" />
                                      <input type="file" class="form-control-file" id="image" name="image"  value="{{ old('image') ?? $zutat -> image }}">
                                    <x-jet-button class="mt-4">
                                            {{ __('Zutat aktualisieren') }}
                                    </x-jet-button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
</x-app-layout>
