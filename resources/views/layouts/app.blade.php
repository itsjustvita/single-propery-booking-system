<!DOCTYPE html>
<html lang="de">
<head>
    <title>WURM HÜTTE</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    @yield('styles')
    @livewireStyles
</head>
<body class="container mx-auto mt-10 mb-10">
<h1 class="text-2xl mb-4">@yield('title')</h1>
<div>
    @if (session()->has('success'))
        <div x-data="{ flash: true}">
            <div x-show="flash"
                 class="mb-10 relative rounded border border-green-400 px-4 py-3 text-green-700 bg-green-400"
                 role="alert">
         <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.5" @click="flash = false"
               stroke="currentColor" class="h-6 w-6 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </span>
                <span class="block font-bold">Success!</span>
                <strong class="font-medium">{{ session('success') }}</strong>
            </div>
        </div>
    @endif


    @yield('content')
</div>
@livewireScripts
</body>
</html>
