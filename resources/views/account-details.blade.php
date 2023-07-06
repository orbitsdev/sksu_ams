<x-main-layout>



    <x-header></x-header>


    <section class="flex h-full min-h-[100vh] ">
        <x-navigation></x-navigation>

        <x-content>

            <div class="flex">
                <div class="mr-6 px-6 py-4 bg-red-400">
                    <img src="{{asset('images/profile2.jpg')}}" alt="sksu-logo.png" class="w-36 h-36 mt-4 ml-2  rounded-lg mb-8">
                </div>
                <div>
                    <div class="mt-4">
                        <p class="rounded-md text-white  py-0.5  bg-green-700 inline-block text-xs px-4">Staff</p>

                    </div>
                    <p class="text-gray-700 text-3xl font-semibold mt-2">Mariea Terisa</p>
                    <div class="flex items-center mt-2">
                        <p class="text-sm text-gray-500 mr-4 w-20">Department</p>
                        <p class="text-sm text-gray-700">Sciene and Health Department</p>
                    </div>
                    <div class="flex items-center mt-2">
                        <p class="text-sm text-gray-500 mr-4 w-20">Course</p>
                        <p class="text-sm text-gray-700">Bachelor of Science in Information Technology</p>
                    </div>
                    <a href="#" class="mt-4 px-6 py-1 transition-all hover:bg-green-600 hover:text-white text-center border-2  border-green-600 inline-block rounded-lg text-green-600  text-sm"> View Profile</a>
                </div>

            </div>

            <div class="mt-8 px-6">
                <p class="text-2xl text-gray-700 font-simibold"> More Information</p>
                <div class="grid grid-cols-2 gap-8 mt-4">
                    <div>

                   
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">ID Number</p>
                        <p class="text-sm text-gray-700">1223612</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Password</p>
                        <p class="text-sm text-gray-700">password</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Age</p>
                        <p class="text-sm text-gray-700">21</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Department</p>
                        <p class="text-sm text-gray-700">Sciene and Health Department</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Course</p>
                        <p class="text-sm text-gray-700">Bachelor of Science in Information Technology</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Campus</p>
                        <p class="text-sm text-gray-700">Isulan</p>
                    </div>
                </div>
                <div>
                    {{-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur velit distinctio, tenetur porro ab sapiente eveniet impedit placeat natus laudantium in ea culpa repudiandae doloribus voluptatum eius. Voluptatem, laborum ut! --}}
                </div>
                </div>
            </div>
          
        </x-content>

    </section>





</x-main-layout>
