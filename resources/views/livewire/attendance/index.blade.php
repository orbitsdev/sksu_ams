<div class=" h-screen relative">

    {{-- <div class="h-full absolute left-0 w-80 bg-white shadow-xl p-4 overflow-y-auto">
        <div class="text-center text-2xl uppercase pt-2 text-gray-400"> Time In </div>

        <div class="mt-8">
            @php
                $samples = [1,23,4,5,6,6,7,8,8,9,9,42349,9,4234];   
            @endphp

            @foreach ($samples as $item)
            <div class="border-b border-gray-300 py-2 text-gray-400">
                <p >Maria Clasra Teresa Junior - (staff)</p>
                <p class="">{{now()->timezone('Asia/Manila')->format('h:i:s A')}}</p>
                <div>
                    <p class=" rounded px-1 text-sm inline-block italic " >Staff</p>

                </div>
            </div>
            @endforeach
        </div>

    </div> --}}
    {{-- <div class="h-full absolute right-0 w-80 bg-white shadow-xl p-4 overflow-y-auto">
        <div class="text-center text-2xl uppercase pt-2 text-gray-400"> Time In </div>

        <div class="mt-8">
            @php
                $samples = [1,23,4,5,6,6,7,8,8,9,9,42349,9,4234];   
            @endphp

            @foreach ($samples as $item)
            <div class="border-b border-gray-300 py-2 text-gray-400">
                <p >Maria Clasra Teresa Junior - (staff)</p>
                <p class="">{{now()->timezone('Asia/Manila')->format('h:i:s A')}}</p>
               
            </div>
            @endforeach
        </div>

    </div> --}}

    {{-- <x-dialog /> --}}



    <div class="max-w-[1200px]   mx-auto h-screen">
        <div class=" h-full flex justify-center items-center ">

            <section class="grid grid-cols-12 w-[80%] content-center items-stretch shadow-2xl ">
                <div class="px-10 pb-2 pt-12 bg-gray-50 col-span-6   ">



                    <p class="uppercase text-3xl text-gray-500 text-center tracking-tight pb-10"> Attendance Monitoring
                        System</p>
                    {{-- <div class="flex justify-center mt-2">

                            <svg class="h-36 w-36 fill-gray-900 "  id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.61 122.88"><defs><style>.cls-1{fill-rule:evenodd;}</style></defs><title>qr-code-scan</title><path class="cls-1" d="M26.68,26.77H51.91V51.89H26.68V26.77ZM35.67,0H23.07A22.72,22.72,0,0,0,14.3,1.75a23.13,23.13,0,0,0-7.49,5l0,0a23.16,23.16,0,0,0-5,7.49A22.77,22.77,0,0,0,0,23.07V38.64H10.23V23.07a12.9,12.9,0,0,1,1-4.9A12.71,12.71,0,0,1,14,14l0,0a12.83,12.83,0,0,1,9.07-3.75h12.6V0ZM99.54,0H91.31V10.23h8.23a12.94,12.94,0,0,1,4.9,1A13.16,13.16,0,0,1,108.61,14l.35.36h0a13.07,13.07,0,0,1,2.45,3.82,12.67,12.67,0,0,1,1,4.89V38.64h10.23V23.07a22.95,22.95,0,0,0-6.42-15.93h0l-.37-.37a23.16,23.16,0,0,0-7.49-5A22.77,22.77,0,0,0,99.54,0Zm23.07,99.81V82.52H112.38V99.81a12.67,12.67,0,0,1-1,4.89,13.08,13.08,0,0,1-2.8,4.17,12.8,12.8,0,0,1-9.06,3.78H91.31v10.23h8.23a23,23,0,0,0,16.29-6.78,23.34,23.34,0,0,0,5-7.49,23,23,0,0,0,1.75-8.8ZM23.07,122.88h12.6V112.65H23.07A12.8,12.8,0,0,1,14,108.87l-.26-.24a12.83,12.83,0,0,1-2.61-4.08,12.7,12.7,0,0,1-.91-4.74V82.52H0V99.81a22.64,22.64,0,0,0,1.67,8.57,22.86,22.86,0,0,0,4.79,7.38l.31.35a23.2,23.2,0,0,0,7.5,5,22.84,22.84,0,0,0,8.8,1.75Zm66.52-33.1H96v6.33H89.59V89.78Zm-12.36,0h6.44v6H70.8V83.47H77V77.22h6.34V64.76H89.8v6.12h6.12v6.33H89.8v6.33H77.23v6.23ZM58.14,77.12h6.23V70.79h-6V64.46h6V58.13H58.24v6.33H51.8V58.13h6.33V39.33h6.43V58.12h6.23v6.33h6.13V58.12h6.43v6.33H77.23v6.33H70.8V83.24H64.57V95.81H58.14V77.12Zm31.35-19h6.43v6.33H89.49V58.12Zm-50.24,0h6.43v6.33H39.25V58.12Zm-12.57,0h6.43v6.33H26.68V58.12ZM58.14,26.77h6.43V33.1H58.14V26.77ZM26.58,70.88H51.8V96H26.58V70.88ZM32.71,77h13V89.91h-13V77Zm38-50.22H95.92V51.89H70.7V26.77Zm6.13,6.1h13V45.79h-13V32.87Zm-44,0h13V45.79h-13V32.87Z"/></svg>
                        </div> --}}
                    <div class="mt-7">
                        <p for="name" class="block font-medium text-sm  text-gray-500"> ID Number </p>


                        <x-input wire:model="idnumber"
                            class="block border-gray-300 active:border-green-600 focus:border-green-600 outline-emerald-500 p-2 mt-1 w-full h-12" />
                    </div>

                    {{-- <div class="mt-5">
                        <p for="name" class="block font-medium text-sm  text-gray-500"> Password </p>
                        <x-input wire:model="password"
                            class="block  border-gray-300 active:border-green-600 focus:border-green-600 outline-emerald-500 p-2 mt-1 w-full h-12" />
                    </div> --}}


                    <div class="mt-8 flex justify-end">
                        <x-button wire:click="login" spinner="login"
                            class="sk-button px-[34px] py-[12px]  w-full justify-center ">
                           Submit
                        </x-button>
                    </div>



                    <div class="pt-16 flex  justify-end flex-col ">
                        <a href="{{ route('dashboard') }}"
                            class="tex-sm text-slate-500 hover:text-green-700 ">Admin?</a>
                        <p class="text-slate-500 text-sm "> Unauthorized personnel are not permitted access to this area
                        </p>
                    </div>
                </div>
                <div class="p-10  sksu-primary col-span-6 flex items-center justify-center min-h-[560px]">
                    <img src="{{ asset('/images/sksulogo.png') }}" alt="" class="w-[300px] h-[300px]">
                </div>
            </section>

        </div>
    </div>

    <x-modal.card align="center" blur wire:model="isSuccess" max-width="6xl" show="true" class="ok"
        spacing="p-20">
        @if ($account != null && $recordDay != null)

        @php
        $accountLoginRecord = $account->logins()->latest()->first();
        $logoutrecord = $accountLoginRecord->logout;
        @endphp
            <div class="modal-c rounded-md p-6 relative">

                <img src="{{ asset('images/sksulogo.png') }}" alt="sksu-logo.png"
                    class="w-32 h-32 mx-auto absolute top-[-60px] left-0 right-0">

                <div class="grid grid-cols-2 ">

                    <div class="mt-6 flex-2  flex items-center justify-center h-[300px] w-full  pr-16 ">
                        <div class="w-[400px] h-[300px] rounded">
                            <a href="{{ Storage::url($account->profile_path) }}" target=_blank>

                                <img src="{{ Storage::url($account->profile_path) }}" alt="profile.jpg"
                                class="h-full w-full object-cover rounded">
                            </a>
                        </div>
                        {{-- <div  class=" bg-white absolute w-[400px] h-[300px] z-[-1px]"> </div> --}}
                    </div>



                    <div class="mt-2 ">
                        <div class="mm  relative text-center text-white text-xl font-bold uppercase pt-4">
                            @if( $logoutrecord->status == 'Not Logout')
                            <div
                                class="bg-white  rounded-full w-[70px] h-[70px] text-green-700  text-4xl p-1 inline-flex items-center justify-center uppercase">
                                In
                            
                            </div>
                            @endif  
                            @if( $logoutrecord->status == 'Logged out')
                            <div
                                class="bg-white  rounded-full w-[70px] h-[70px] text-green-700  text-3xl p-1 inline-flex items-center justify-center uppercase">
                              
                                Out
                            </div>
                            @endif  
                        </div>

                        <P class="text-4xl font-bold uppercase  ">
                            {{ $recordDay->created_at->timezone('Asia/Manila')->format('F d, Y') }}

                        </P>

                        @if ($accountLoginRecord)

                          

                            @if ($logoutrecord->status == 'Not Logout')
                                <P class="text-4xl font-bold uppercase  ">
                                    {{ $accountLoginRecord->created_at->timezone('Asia/Manila')->format('h:i:s A') }}
                                </P>
                            @endif
                            @if ($logoutrecord && $logoutrecord->status == 'Logged out')
                                <P class="text-4xl font-bold uppercase  ">
                                    {{ $logoutrecord->updated_at->timezone('Asia/Manila')->format('h:i:s A') }}

                                </P>
                            @endif
                        @endif
                        <div class="  mt-6">
                            <P class="text-2xl p-0 font-semibold capitalize">
                                {{ $account->first_name }} {{ $account->last_name }}
                            </P>

                        </div>
                        <P class="mt-5 text-lg capitalize ">
                            {{ $account->course->department->name }}
                        </P>
                        <P class=" text-lg capitalize ">
                            {{ $account->course->name }}
                        </P>
                        <P class=" text-lg capitalize ">
                            {{ $account->role->name }}
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
        @endif
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">

                <div class="flex">
                    {{-- <x-button flat label="Cancel" x-on:click="close" /> --}}
                    <x-button class="bg-green-700 ok transition-all" primary label="DONE" icon="check"
                        x-on:click="close" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>


    <x-modal.card align="center" blur wire:model="hasError">



        @if ($errorType == 'not-found')
            <x-error-content :image="'not-found.png'" :message="$errorMessage" />
        @endif
        @if ($errorType == 'exception')
            <x-error-content :image="'error.png'" :message="$errorMessage" />
        @endif


        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">


                <div class="flex">

                    <x-button class="ok" label="I Understand" x-on:click="close" />
                </div>
            </div>
        </x-slot>

    </x-modal.card>
</div>
