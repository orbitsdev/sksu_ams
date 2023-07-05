<div class=" h-screen">
    {{-- <x-dialog /> --}}



    <div class="max-w-[1200px]   mx-auto h-screen">
        <div class=" h-full flex justify-center items-center ">

            <section class="grid grid-cols-12 w-[80%] content-center items-stretch shadow-2xl ">
                <div class="px-10 pb-2 pt-12 bg-gray-50 col-span-6   ">

                   

                        <p class="uppercase text-3xl text-gray-500 text-center tracking-tight pb-10"> Attendance Monitoring System</p>

                        <div class="mt-7">
                            <p for="name" class="block font-medium text-sm  text-gray-500" > ID Number </p>


                            <x-input wire:model="idnumber" class="block border-gray-300 active:border-green-600 focus:border-green-600 outline-emerald-500 p-2 mt-1 w-full h-12" />
                        </div>

                        <div class="mt-5">
                            <p for="name" class="block font-medium text-sm  text-gray-500" > Password </p>
                            <x-input wire:model="password" class="block  border-gray-300 active:border-green-600 focus:border-green-600 outline-emerald-500 p-2 mt-1 w-full h-12" />
                        </div>
                        

                        <div class="mt-8 flex justify-end">
                            <x-button  wire:click="login" spinner="login" class="sk-button px-[34px] py-[12px]  w-full justify-center ">
                                Log in
                            </x-button>
                        </div>

                   

                    <div class="pt-16 flex  justify-end flex-col ">
                        <a href="{{route('dashboard')}}" class="tex-sm text-slate-500 hover:text-green-700 ">Admin?</a>
                        <p class="text-slate-500 text-sm "> Unauthorized personnel are not permitted access to this area</p>
                    </div>
                </div>
                <div class="p-10  sksu-primary col-span-6 flex items-center justify-center min-h-[560px]">
                        <img src="{{asset('/images/sksulogo.png')}}" alt="" class="w-[300px] h-[300px]" >    
                </div>
            </section>

        </div>
    </div>

    <x-modal.card  align="center" blur wire:model="isSuccess" max-width="6xl" show="true"  class="ok" spacing="p-20">
        
        <div class="modal-c rounded-md p-6 relative">

            <img src="{{asset('images/sksulogo.png')}}" alt="sksu-logo.png" class="w-32 h-32 mx-auto absolute top-[-60px] left-0 right-0">

            <div class="grid grid-cols-2 mt-14">

                <div class=" flex-2  flex items-center justify-center h-[300px] w-full ">
                    <div class="w-[400px] h-[300px]">
                        <img src="{{ asset('images/profile2.jpg') }}" alt="profile.jpg" class="h-full w-full object-cover">
                    </div>
                  </div>
                  
                
                <div class=" ">
                    <P class="text-4xl font-bold uppercase  ">
                        {{now()->timezone('Asia/Manila')->format('F d, Y')}}
            
                    </P>

                    <P class="text-4xl font-bold uppercase  ">
                        {{now()->timezone('Asia/Manila')->format('h:i A')}}
            
                    </P>

                    <div class="  mt-8">
                        <P class="text-2xl p-0 font-semibold">
                           Maria Clara Angeles Trersiake Kate
                        </P>

                    </div>
                    <P class="mt-4 text-lg ">
                        Department Of Science and Health
                    </P>
                    <P class=" text-lg ">
                       Bachlor Of Science in Political Science
                    </P>
                    <P class=" text-lg ">
                        Student
                    </P>
                </div>
            </div>
            
       
    </div>

        {{-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="Name" placeholder="Your full name" />
            <x-input label="Phone" placeholder="USA phone" />
     
            <div class="col-span-1 sm:col-span-2">
                <x-input label="Email" placeholder="example@mail.com" />
            </div>
     
            <div class="col-span-1 sm:col-span-2 cursor-pointer bg-gray-100 rounded-xl shadow-md h-72 flex items-center justify-center">
                <div class="flex flex-col items-center justify-center">
                    <x-icon name="cloud-upload" class="w-16 h-16 text-blue-600" />
                    <p class="text-blue-600">Click or drop files here</p>
                </div>
            </div>
        </div> --}}
     
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
            
                <div class="flex">
                    {{-- <x-button flat label="Cancel" x-on:click="close" /> --}}
                    <x-button class="bg-green-700 ok transition-all" primary label="Save" x-on:click="close" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
