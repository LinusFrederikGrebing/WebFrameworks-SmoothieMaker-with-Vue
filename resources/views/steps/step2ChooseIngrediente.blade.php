
@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.progressbar')
        @include('layouts.groesse')
        <div class=" mt-5">
            <div>
                <h2 class="sr-only">Steps</h2>
                <div>
                    <ol
                        class="grid grid-cols-1 divide-x divide-gray-100 overflow-hidden rounded-lg border border-gray-100 text-sm text-gray-500 sm:grid-cols-3 w-3/5">
                        <button onclick="window.location='{{ route('showFruits') }}'">
                            <li class="flex items-center justify-center p-4 bg-gray-600">
                                <img src="/images/fruitsicon.png" alt="" class="mr-2 h-7 w-7 flex-shrink-0">
                                <p class="leading-none">
                                    <strong class="block text-white font-bold"> Früchte </strong>
                                </p>

                            </li>
                        </button>
                        <button onclick="window.location='{{ route('showVeggie') }}'">
                            <li class="relative flex items-center justify-center bg-gray-500 p-4">
                                <span
                                    class="absolute -left-2 top-1/2 hidden h-4 w-4 -translate-y-1/2 rotate-45 border border-b-0 border-l-0 border-gray-100 bg-gray-600 sm:block">
                                </span>

                                <span
                                    class="absolute -right-2 top-1/2 hidden h-4 w-4 -translate-y-1/2 rotate-45 border border-b-0 border-l-0 border-gray-100 bg-gray-500 sm:block">
                                </span>

                                <img src="/images/vegetablesicon.png" alt="" class="mr-2 h-7 w-7 flex-shrink-0">
                                <p class="leading-none">
                                    <strong class="block text-white font-bold"> Gemüse </strong>
                                </p>
                            </li>
                        </button>
                        <button onclick="window.location='{{ route('showLiquids') }}'">
                            <li class="flex items-center justify-center p-4 bg-gray-600">
                                <img src="/images/liquidicon.png" alt="" class="mr-2 h-7 w-7 flex-shrink-0">
                                <p class="leading-none">
                                    <strong class="block text-white font-bold"> Flüssigkeit </strong>
                                </p>
                            </li>
                        </button>
                    </ol>
                </div>
            </div>
        </div>
        <div class="flex test w-100">
            <div class="px-4 basis-3/5">
                <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4 mx-auto">
                    @foreach ($zutaten as $zutat)
                        <div>
                            <div
                                class="relative overflow-hidden transition duration-300 transform rounded lg:hover:-translate-y-2 px-2">
                                <img class="object-cover h-12 md:h-20 xl:h-28" src="/images/{{ $zutat['image'] }}" />
                                <div
                                    class="absolute w-44 inset-0 flex flex-col justify-center px-5 py-4 text-center transition-opacity duration-300 bg-black bg-opacity-75 opacity-0 hover:opacity-100">
                                    <p class="mb-1 text-lg font-bold text-gray-100">{{ $zutat['name'] }}</p>
                                    <p class="mb-4 text-xs text-gray-100">Preis: {{ $zutat['price'] }}€ </p>
                                    <p class="mb-4 text-xs text-gray-100">evtl. Bereich für Nährwerte der Zutaten </p>
                                </div>
                            </div>
                            <div class="mx-auto my-2">
                                <div>
                                    <span class="text-dark">Zutat: {{ $zutat['name'] }}</span>
                                    <div>
                                        <span class="font-weight-bold"> Preis: {{ $zutat['price'] }}€</span>
                                    </div>
                                </div>
                                <form action="/addCart/{{ $zutat['id'] }}" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="flex">
                                        <input id="amount" type="number" step="1" min="1"
                                            max="20" name="amount" value="1">
                                        <button class="btn wkorb">
                                            <svg class="flex-1 w-8 h-8 fill-current ml-3" viewbox="0 0 24 24">
                                                <path
                                                    d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5.5C20.95,5.34 21,5.17 21,5A1,1 0 0,0 20,4H5.21L4.27,2M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                                <!-- <form  action="/addCart/{{ $zutat['id'] }}"  enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="flex">
                                <input id="amount" type="number"  step="1" min="1" max="20"
                                        name="amount" value="1">
                                <button onclick="setImg('/images/{{ $zutat['image'] }}')" class="btn wkorb" > <svg class="flex-1 w-8 h-8 fill-current ml-3" viewbox="0 0 24 24">
                                <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5.5C20.95,5.34 21,5.17 21,5A1,1 0 0,0 20,4H5.21L4.27,2M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"/>
                                </svg></button>
                                </div>
                            
                            </form> -->
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="buttonsBottom">
                    <div class="center-con">
                        <div class="arrcontainer">
                            <div id="cta">
                                <button class="button-left redbg back" data-href="{{ route('showBottleSizes') }} ">
                                    <span class="arrow prev arrow-left"></span>
                                    <span class="arrow segunda prev arrow-left segunda-left  "></span>
                                    Zurück!
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="center-con">
                        <div class="arrcontainer">
                            <div id="cta">
                                <button class="button-right greenbg"
                                    onclick="window.location='{{ route('showCard') }}'">
                                    Weiter!
                                    <span class="arrow next "></span>
                                    <span class="arrow segunda next "></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="basis-2/5">
                <livewire:mixer />
            </div>
        </div>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script>
            handleFormSubmit();
            handleArrowClick();
            handleBackClick();

            function handleFormSubmit() {
                $('.btn.wkorb').click(function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    var url = form.prop('action');
                    var data = form.serialize();

                    $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        success: function(response) {
                            if (response.image) {
                                setImg(response.image, response.reqCount);
                                setNewCounter(response.count);
                                progress(response.count, response.amount);
                            } else {
                                showAlertTooMany();
                            }
                        }
                    });
                });
            }

            function handleArrowClick() {
                $('.arrcontainer').click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $('.arrow').toggleClass('bounceAlpha');
                });
            }

            function handleBackClick() {
                $(".back").click(function(e) {
                    e.preventDefault();
                    var self = $(this);
                    removeAllAlert(self);
                });
            }

            function removeAllAlert(self) {
                Swal.fire({
                    title: 'Bist du Dir sicher?',
                    text: "Wenn du zurückgehst wird deine bisherige Zusammenstellung unwiederruflich gelöscht!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#6D9E1F',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Weiter zurück!',
                    cancelButtonText: 'Abbrechen!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = self.data('href');
                    }
                });
            }

            function showAlertTooMany() {
                Swal.fire({
                    title: 'Du hast zu viele Zutaten ausgewählt!',
                    text: "",
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#6D9E1F',
                    confirmButtonText: 'Okay!',
                });
            }

            function setNewCounter(newCounter) {
                $(".cart-count").html(newCounter);
            }
        </script>

@endsection