<div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-container {
                visibility: visible !important;
                width: 100%;
            }

            .print-container * {
                visibility: visible !important;
            }

            /* .b {
            visibility: hidden;
          } */

            /* .print-container,
          .print-container * {
            width: 100%;
            visibility: visible;
            
          
          }

          .print-container .sklogo{
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
          
          } */

            .print-container {
                color: black;
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
            }


        }
    </style>

    @section('title')
        Reports
    @endsection

    <div class="border border-gray-50 p-6">
        @foreach ($courses as $item)
            {{$item->name}}
            {{$item->id}}
            @endforeach
        <div class="max-w-4xl m-auto  grid grid-cols-2 gap-10">

            <div>
                <x-select searchable label="Select Department" placeholder="Select one department" wire:model="department">

                    @foreach ($departments as $item)
                        <x-select.option label="{{ \Str::ucfirst($item->name) }}" value="{{ $item->id }}" />
                    @endforeach

                </x-select>
                {{$department}}
                <x-select searchable label="Course" placeholder="Select one department" wire:model="course" value="{{$course}}" class="mt-4">
                    
                    @foreach ($courses as $item)
                    <x-select.option label="{{ \Str::ucfirst($item->name) }}" value="{{ $item->id }}" />
                        @endforeach
                        
                    </x-select>
                    {{$course}}
            </div>
       

        <div>

            <div>
                <x-datetime-picker label="From" wire:model="from" without-time />
            </div>
            <div class="mt-4">
                <x-datetime-picker label="To" wire:model="to" without-time  />
            </div>
        </div>
    </div>
    <div class="max-w-4xl m-auto  flex justify-center  mt-2 pb-4">

        <div class="mt-4 mx-6">
            <x-checkbox id="student" lg label="Students" wire:model="student" />
            {{$student}}
            
        </div>
        <div class="mt-4 mx-6">
            <x-checkbox id="faculty" lg label="Faculty" wire:model="staff" />
            {{$staff}}
            
        </div>
        <div class="mt-4 mx-6">
            <x-checkbox id="morning" lg label="Morning" wire:model="morning" />
            {{$morning}}
            
        </div>
        <div class="mt-4 mx-6">
            <x-checkbox id="noon" lg label="Noon" wire:model="noon" />
            {{$noon}}
    </div>
</div>
    </div>

    {{-- <div class=" mb-24">    

        <div class="max-w-4xl m-auto flex mt-6 justify-end ">
            <x-button class="ok" icon="printer" spinner="print" wire:click="print"  > Print</x-button>
        </div>
        <div class="print-container  max-w-4xl mt-4 mx-auto border-2 border-gray-200">

            <div>

            </div>

            <div class=" sklogo  rounded p-6 pt-4 flex items-start justify-between">
                <div class="flex-1  block">
                    <img src="{{ asset('images/sksulogo.png') }}" alt="sksu-logo.png" style="width: 96px; height: 96px; margin: 0 auto" >
                </div>
                <div class="text-center flex-6  ">
                    <p>Republic Of The Philippines</p>
                    <p class="text-lg text-gray-900 font-bold">Sultan Kudarat State Univerisity</p>
                    <p>Access Campus, Ejc Montilla Tacurong City</p>
                    <p>Province of Sultan Kudarat</p>
                    <p class="uppercase text-xl mt-8 font-bold text-gray-900">Attendance</p>
                </div>
                <div class="flex-1  ">
                    <div class="w-28 h-28"></div>
                </div>
            </div>
            <div class="flex justify-between px-6 mt-9 text-gray-900 font-semibold">
                <div>
                    <p>College of Health and Sciences</p>
                    <p>{{now()->format('F d, Y')}}</p>
                </div>
                
                <div>
                    <p>Diploma in Midwifery</p>
                </div>

            </div>


            @php
                $samples = [1,23,4,5,6,44,234,23,423,4,234,234,234,]
            @endphp
            <div class="mt-2 ">
                <div class="px-6 overflow-x-auto">
                    <div class="inline-block min-w-full py-2 align-middle">
                      <table class="min-w-full ">
                        <thead>
                          <tr>
                              <th scope="col" class=" py-3.5 text-left  font-semibold text-gray-900">Name</th>
                            <th scope="col" class=" py-3.5 text-left  font-semibold text-gray-900">Position</th>
                            <th scope="col" class=" py-3.5 text-center  font-semibold text-gray-900">Morning in & out</th>
                            <th scope="col" class=" py-3.5 text-right  font-semibold text-gray-900">Afternoon in & out</th>
                           
                          </tr>
                        </thead>
                        <tbody class=" bg-white">


                            @forelse ($samples as $item)
                            <tr>
                                <td class="whitespace-nowrap  py-2  text-left text-gray-500">Karla Balhinon</td>
                                  <td class="whitespace-nowrap  py-2  text-ledt text-gray-500">Staff</td>
                                    <td class="whitespace-nowrap  py-2  text-center text-gray-500">{{now()->format('h:i a')}} | {{now()->format('h:i a')}}</td>
                                <td class="whitespace-nowrap  py-2  text-right text-gray-500">{{now()->format('h:i a')}} | {{now()->format('h:i a')}}</td>
                              </tr>
                            @empty
                                
                            @endforelse
                          
              
                       
                        </tbody>
                      </table>
                    </div>
                  </div>
            
            </div>


        </div>
    </div> --}}
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('printDoc', function() {

                window.print();
            });
        });
    </script>

</div>
