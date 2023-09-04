<div>




    <div class="p-6">

        {{-- <div class="grid grid-cols-6">
                           
            
        </div> --}}
        <div class="mt-4 mx-auto max-w-6xl">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                {{-- <div class="col-span-2 md:col-span-1">
                    <x-select searchable label="School Year" placeholder="Select school year" wire:model="schoolYear" value="{{$schoolYear}}">
                        @foreach ($schoolYears as $item)
                            <x-select.option label="{{ $item->from .' - '. $item->to}}" value="{{ $item->id }}" searchable />
                        @endforeach
                    </x-select>
                    
                </div> --}}
                <div class="col-span-2 md:col-span-2">
                    <x-native-select searchable label="Select Department" placeholder="Select one department"
                        wire:model="department">
                        @foreach ($departments as $item)
                            <option value="{{ $item->id }}"> {{ \Str::ucfirst($item->name) }} </option>
                        @endforeach
                    </x-native-select>
                </div>
                @if (!$staff)

                    <div class="col-span-2 md:col-span-2">
                        <x-native-select label="Select Course" placeholder="Select one course"
                            wire:model="selected_course" searchable>
                            @foreach ($courses as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }}</option>
                            @endforeach

                        </x-native-select>
                        {{-- {{$course}} --}}
                    </div>

                    @else
                    <div class="col-span-2"></div>
                @endif

                <div class="col-span-2 md:col-span-1">
                    <x-datetime-picker label="From" wire:model="from" without-time />
                </div>
                <div class="col-span-2 md:col-span-1">
                    <x-datetime-picker label="To" wire:model="to" without-time />
                </div>
                <div class="col-span-2 md:col-span-1 flex items-center ">
                    <div class="mr-4">
                        <x-checkbox id="morning" lg label="Morning" wire:model="morning" />

                    </div>
                    <div class="mr-4">
                        <x-checkbox id="noon" lg label="Noon" wire:model="noon" />
                    </div>
                    <div class="mr-4">

                        <x-checkbox id="student" lg label="Students" wire:model="student" />
                    </div>
                    <div class="mr-4">
                        <x-checkbox id="faculty" lg label="Faculty" wire:model="staff" />

                    </div>
                </div>
            </div>
        </div>




    </div>
    <div class="">
        <div class=" max-w-6xl mx-auto  flex justify-end mb-4">
            <x-button class="okt mr-4" icon="download" outline  spinner="export" wire:click="export"> Download </x-button>
            <x-button class="ok" icon="printer" spinner="print" wire:click="print"> Print</x-button>
        </div>
        <div class=" max-w-6xl print-container mx-auto border-2 border-gray-200">



            <div class=" sklogo  rounded p-6 pt-4 flex items-start justify-between">
                <div class="flex-1  block">
                    <img src="{{ asset('images/sksulogo.png') }}" alt="sksu-logo.png"
                        style="width: 96px; height: 96px; margin: 0 auto">
                </div>
                <div class="text-center flex-6  ">
                    <p>Republic Of The Philippines</p>
                    <p class="text-lg text-gray-900 font-bold">Sultan Kudarat State Univerisity</p>
                    <p>Access Campus, Ejc Montilla Tacurong City</p>
                    <p>Province of Sultan Kudarat</p>
                    <p class="uppercase text-lg mt-4 font-semibold text-gray-900">Attendance</p>
                </div>
                <div class="flex-1  ">
                    <div class="w-28 h-28"></div>
                </div>
            </div>
            <div class="flex justify-between px-6 mt-9 text-gray-900 font-semibold">
                <div>
                    <p>College of Health and Sciences</p>
                    <p>{{ now()->format('F d, Y') }}</p>
                </div>

                <div>
                    <p>Diploma in Midwifery</p>
                </div>

            </div>


            <div class="mt-2 ">
                <div class="px-6 ">
                    <table class="w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col" class=" px-3 py-2.5 text-left text-sm font-semibold text-gray-900 ">
                                    Name</th>
                                <th scope="col" class=" px-3 py-2.5 text-left text-sm font-semibold text-gray-900 ">
                                    Department</th>
                                <th scope="col" class=" px-3 py-2.5 text-left text-sm font-semibold text-gray-900 ">
                                    Role</th>
                                <th scope="col" class=" px-3 py-2.5 text-left text-sm font-semibold text-gray-900 ">
                                    Course</th>
                                <th scope="col"
                                    class=" px-3 py-2.5 text-center text-sm  font-semibold text-gray-900">Morning in &
                                    out</th>
                                <th scope="col"
                                    class=" px-3 py-2.5 text-center text-sm  font-semibold text-gray-900">Afternoon in &
                                    out</th>

                            </tr>
                        </thead>
                        <tbody class=" bg-white">


                            @forelse ($logs as $item)
                                <tr>
                                    <td class="capitalize whitespace-nowrap py-2 text-left text-gray-500">
                                        {{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}
                                    </td>

                                    <td class="whitespace-nowrap px-3 py-2.5 text-sm text-gray-600">
                                        {{ $item->department_name ?? '' }} </td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-sm text-gray-600">
                                        {{ $item->role_name ?? '' }}</td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-sm text-gray-600">
                                        {{ $item->course_name ?? '' }}</td>
                                    <td class="whitespace-nowrap text-center px-3 py-2.5 text-sm text-gray-600">
                                        @if (optional($item->login)->morning_in)
                                            {{ \Carbon\Carbon::parse($item->login->morning_in)->format('h:i:s A') }}
                                        @elseif (!$item->created_at->isToday())
                                            Did not login
                                        @else
                                            NONE
                                        @endif
                                        |
                                        @if (optional($item->login)->morning_out)
                                            {{ \Carbon\Carbon::parse($item->login->morning_out)->format('h:i:s A') }}
                                        @elseif (!$item->created_at->isToday())
                                            Did not logout
                                        @else
                                            NONE
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap text-center px-3 py-2.5 text-sm text-gray-600">
                                        @if (optional($item->login)->noon_in)
                                            {{ \Carbon\Carbon::parse($item->login->noon_in)->format('h:i:s A') }}
                                        @elseif (!$item->created_at->isToday())
                                            Did not login
                                        @else
                                            NONE
                                        @endif
                                        |
                                        @if (optional($item->login)->noon_out)
                                            {{ \Carbon\Carbon::parse($item->login->noon_out)->format('h:i:s A') }}
                                        @elseif (!$item->created_at->isToday())
                                            Did not logout
                                        @else
                                            NONE
                                        @endif
                                    </td>




                                </tr>
                            @empty
                            @endforelse



                        </tbody>
                    </table>
                </div>

            </div>


        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('printRe', function() {

                window.print();
            });
        });
    </script>

</div>
