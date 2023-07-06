<x-main-layout>



    <x-header></x-header>


    <section class="flex h-full min-h-[100vh] ">
        <x-navigation></x-navigation>

        <x-content>

            <div class="p-4 grid grid-cols-4 gap-6">
                
                @livewire('total-account')
                @livewire('total-inside')
                @livewire('total-staff')
                @livewire('total-student')
                
                
                
             
           
                
             
            

            </div>
            @livewire('realtime-attendance')
        </x-content>

    </section>





</x-main-layout>
