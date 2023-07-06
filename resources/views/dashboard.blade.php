<x-main-layout>



    <x-header></x-header>


    <section class="flex h-full min-h-[100vh] ">
        <x-navigation></x-navigation>

        <x-content>

            <div class="p-4 grid grid-cols-4 gap-6">
                
                <div class="shadow rounded-md bg-white px-4 py-4 border  ">
                    <div class="flex justify-between px-2">
                    
                        <div>
                            <p class="text-lg font-bold text-gray-700"> 1233213</p>
                            <p class=" text-gray-500 text-sm font-semibold ">Total Users</p>
                        </div>
                        <div class="rounded-xl p-2 h-12 w-12 inline-flex items-center justify-center bg-gray-50 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 text-gray-500  ">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="#" class="inline-block text-gray-500 px-2 py-1 rounded-lg transition-all hover:bg-gray-50 text-sm"> View More Details</a>
                
                    </div>
                </div>
                @livewire('total-inside')

         
                
                <div class="shadow rounded-md bg-white px-4 py-4 border  ">
                    <div class="flex justify-between px-2">
                    
                        <div>
                            <p class="text-lg font-bold text-gray-700"> 40</p>
                            <p class=" text-gray-500 text-sm font-semibold ">Total Users Exit  </p>
                        </div>
                        <div class="rounded-xl p-2 h-12 w-12 inline-flex items-center justify-center bg-gray-50 ">
                           
                            <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500  ">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                              </svg>
                              
                
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="#" class="inline-block text-gray-500 px-2 py-1 rounded-lg transition-all hover:bg-gray-50 text-sm"> View More Details</a>
                
                    </div>
            </div>
                
                <div class="shadow rounded-md bg-white px-4 py-4 border  ">
                    <div class="flex justify-between px-2">
                    
                        <div>
                            <p class="text-lg font-bold text-gray-700"> 60 </p>
                            <p class=" text-gray-500 text-sm font-semibold ">Total Students  </p>
                        </div>
                        <div class="rounded-xl p-2 h-12 w-12 inline-flex items-center justify-center bg-gray-50 ">
                            

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500  ">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                              </svg>
                              
                
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="#" class="inline-block text-gray-500 px-2 py-1 rounded-lg transition-all hover:bg-gray-50 text-sm"> View More Details</a>
                
                    </div>
            </div>
           
                
             
            

            </div>
            @livewire('realtime-attendance')
        </x-content>

    </section>





</x-main-layout>
