<main class="w-full mx-auto px-12 ">
    <h1 class="text-3xl font-bold text-gray-800 mb-5 mt-5  @if(View::hasSection('title')) py-4 @endif">
        @yield('title')
    </h1>
    {{$slot}}
</main>