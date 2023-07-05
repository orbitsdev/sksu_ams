
    <header class=" sksu-bg ">
        {{-- <div class="p-3 bg-orange-600 text-sm ">
            <p class="text-center text-white"> New Features Added In The System</p>
             </div> --}}
        <div class="max-w-7xl m-auto text-white flex items-center justify-between  ">

            <div class=""></div>
            <div class="">
            <ul class="flex items-center justify-between">
                <a href="{{route('attendance.index')}}" class="inline-block hover:bg-[#045820] transition-all ease rounded-xs  px-4 py-4 text-sm"> Attendance </a>
                <a href="" class="inline-block hover:bg-[#045820] transition-all ease rounded-xs  px-4 py-4 text-sm"> Home </a>
                <a href="" class="inline-block hover:bg-[#045820] transition-all ease rounded-xs  px-4 py-4 text-sm"> Update Information</a>
                <a href="" class="inline-block hover:bg-[#045820] transition-all ease rounded-xs  px-4 py-4 text-sm"> Help Desk</a>

                <div class="profile pl-4 py-4 relative" x-data="{ open: false }">
                    <img src="{{asset('images/profile-sample.jpg')}}" alt="profile.jpg" class="w-10 h-10 rounded-full border-2 border-white cursor-pointer"  @click="open = !open">
                    
                    <div class="content absolute z-2 w-40 top-[65px] right-0 bg-white shadow-md rounded" 
                    x-cloak x-show="open" @click.away="open = false" >
                        <form method="POST" action="{{route('logout')}}">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 rounded transition-all w-full"> 
                                <div class="flex items-center">
                               
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                  </svg>
                                  
                                  <p>
                                      Logout 
                                    </p>  
                                </div>
                            </button>
                        </form>
                        <a href="{{route('profile.show')}}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 rounded transition-all w-full"> 
                            <div class="flex items-center">
                           
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                  </svg>
                                  
                              
                              <p>
                                    Profile 
                                    
                                </p>  
                            </div>
                        </a>
                    </div>
                </div>
                
                
            </ul>
        </div>
    </div>
    </header>
