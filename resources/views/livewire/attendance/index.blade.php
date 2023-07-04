<div class=" h-screen">
    <x-dialog />



    <div class="max-w-[1200px]   mx-auto h-screen">
        <div class=" h-full flex justify-center items-center ">

            <section class="grid grid-cols-12 w-[80%] content-center items-stretch shadow-2xl ">
                <div class="px-10 pb-2 pt-12 bg-gray-50 col-span-6   ">

                    <form action="">

                        <p class="uppercase text-3xl text-gray-500 text-center tracking-tight pb-10"> Attendance Monitoring System</p>

                        <div class="mt-7">
                            <x-label  class="text-green-800" for="user_id" value="User ID" />
                            <x-input class="block active:border-green-600 focus:border-green-600 outline-emerald-500 p-2 mt-1 w-full h-12" />
                        </div>

                        <div class="mt-5">
                            <x-label  class="text-green-800" for="password" value="{{ __('Password') }}" />
                            <x-input class="block active:border-green-600 focus:border-green-600 outline-emerald-500 p-2 mt-1 w-full h-12" />
                        </div>
                        

                        <div class="mt-8 flex justify-end">

                            <x-button class="bg-gray-200  hover:text-white  px-[34px] py-[12px]  w-full justify-center ">
                                Log in
                            </x-button>
                        </div>

                    </form>

                    <div class="pt-16 flex  justify-end flex-col ">
                        <a href="#" class="tex-sm text-slate-500 ">Admin?</a>
                        <p class="text-slate-500 text-sm "> Unauthorized personnel are not permitted access to this area</p>
                    </div>
                </div>
                <div class="p-10  sksu-primary col-span-6 flex items-center justify-center min-h-[560px]">
                        <img src="{{asset('/images/sksulogo.png')}}" alt="" class="w-[300px] h-[300px]" >    
                </div>
            </section>

        </div>
    </div>
</div>
