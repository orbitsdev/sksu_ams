<div>
    <div class="flex items-center justify-center flex-col ">
     
        {{-- <img src="{{asset('images/not-found.png')}}" alt="" height="300" width="300"> --}}
        <img src="{{asset('images/'.$image)}}" alt="" height="300" width="300">
     
    </div>

    <div class="text-center mt-8 text-lg">
        {{ $message}}

    </div>
</div>