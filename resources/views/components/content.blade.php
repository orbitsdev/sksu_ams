<main class="w-full mx-auto px-8  bg-[#E4E4E4] ">
  
    <div class="shadow rounded-lg mt-8 bg-white">
  <h1 class="text-3xl font-semibold text-gray-700  mt-5 px-6 pb-0 @if(View::hasSection('title')) pt-4 @endif">
        @yield('title')
    </h1>
    <div class="p-4">

        {{$slot}}
    </div>
    </div>
</main>