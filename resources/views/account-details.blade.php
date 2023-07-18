<x-main-layout>



    <x-header></x-header>


    <section class="flex h-full min-h-[100vh] ">
        <x-navigation></x-navigation>

        <x-content>

            <a href="{{ url()->previous() }}" class="ml-6 px-2 inline-flex items-center hover:bg-gray-50  transition-all rounded-lg ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                  </svg>
{{--                   
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-4 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                  </svg>
                   --}}
                <p class="text-md text-gray-400">Back</p>
                </a>
            <div class="flex">
                <div class="mr-6 px-6 py-4  ">
                    <img src="{{asset('images/profile2.jpg')}}" alt="sksu-logo.png" class="w-40 h-40 mt-4 ml-2  rounded-lg mb-8">
                </div>
                <div>
                    <div class="mt-4">
                        <p class="rounded-md text-white  py-0.5  bg-green-700 inline-block text-xs px-4 capitalize">{{$account->role->name}}</p>

                    </div>
                    <p class="text-gray-700 text-3xl font-semibold mt-2 capitalize"> {{$account->first_name}}  {{$account->last_name}}</p>
                    <div class="flex items-center mt-2">
                        <p class="text-sm text-gray-500 mr-4 w-20 capitalize">Department</p>
                        <p class="text-sm text-gray-700">{{$account->course->department->name}}</p>
                    </div>
                    <div class="flex items-center mt-2">
                        <p class="text-sm text-gray-500 mr-4 w-20">Course</p>
                        <p class="text-sm text-gray-700">{{$account->course->name}}</p>
                    </div>
                    <a href="{{Storage::url($account->profile_path)}}" target="_blank" class="mt-4 px-6 py-1 transition-all hover:bg-green-600 hover:text-white text-center border-2  border-green-600 inline-block rounded-lg text-green-600  text-sm"> View Profile</a>
                </div>

            </div>

            <div class="mt-8 px-6">
                <p class="text-2xl text-gray-700 font-simibold"> More Information</p>
                <div class="grid grid-cols-2 gap-8 mt-4">
                    <div>

                   
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">ID Number</p>
                        <p class="text-sm text-gray-800">{{$account->id_number}}</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Password</p>
                        <p class="text-sm text-gray-800">{{$account->password}}</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Age</p>
                        <p class="text-sm text-gray-800">21</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48 capitalize">Department</p>
                        <p class="text-sm text-gray-800">{{$account->course->department->name}}</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Course</p>
                        <p class="text-sm text-gray-800">{{$account->course->name}}</p>
                    </div>
                    {{-- <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Campus</p>
                        <p class="text-sm text-gray-800">Isulan</p>
                    </div> --}}
                </div>
                <div>
                    {{-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur velit distinctio, tenetur porro ab sapiente eveniet impedit placeat natus laudantium in ea culpa repudiandae doloribus voluptatum eius. Voluptatem, laborum ut! --}}
                </div>
                </div>
            </div>
          
        </x-content>

    </section>





</x-main-layout>
