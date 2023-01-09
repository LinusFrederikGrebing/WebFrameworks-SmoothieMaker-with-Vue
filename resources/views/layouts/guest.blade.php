<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
        
    </head>
    <body>
   
    

    
<!-- component -->
<body>
	<nav class="relative px-4 py-2 flex justify-between items-center bg-zinc-700">
		<a class="text-3xl font-bold leading-none" href="#">
        <img src="/img/smoothie.png" alt="Smoothie" title="Smoothie" class="w-12"></img>
		</a>
		<div class="sm:hidden">
			<button class="navbar-burger flex items-center text-blue-600 p-3">
				<svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<title>Mobile menu</title>
					<path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
				</svg>
			</button>
		</div>
		<ul class="hidden absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 sm:flex sm:mx-auto sm:flex sm:items-center sm:w-auto sm:space-x-6">
			<li><a class="text-sm text-white hover:text-lime-500" href="{{ url('/') }}" >Home</a></li>
			<li class="text-gray-300">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
				</svg>
			</li>
			<li><a class="text-sm text-white hover:text-lime-500" href="#">About Us</a></li>
			<li class="text-gray-300">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
				</svg>
			</li>
			<li><a class="text-sm text-white hover:text-lime-500" href="#">Contact</a></li>
		</ul>
		<a class=" sm:inline-block sm:ml-auto sm:mr-3 py-2 px-6 bg-gray-50 hover:bg-lime-500 text-sm text-gray-900 font-bold rounded-xl transition duration-200" href="{{ route('login') }}">Sign In</a>
		<a class=" sm:inline-block py-2 px-6 bg-gray-500 hover:bg-lime-500 text-sm text-white font-bold rounded-xl transition duration-200" href="{{ route('register') }}">Sign up</a>
	</nav>
    @include('sweetalert::alert')
           <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
           </div>
    </body>
</html>
