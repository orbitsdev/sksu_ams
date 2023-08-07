<x-main-layout>




    <section class="flex h-full min-h-[100vh] ">
        <x-navigation></x-navigation>

        <x-content>
            
           
{{-- 

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
                        <p class="text-sm text-gray-700">Biology</p>
                    </div>
                    <div class="flex items-center mt-2">
                        <p class="text-sm text-gray-500 mr-4 w-20">Course</p>
                        <p class="text-sm text-gray-700">Information tehclonly</p>
                    </div>
                    <a href="{{Storage::url($account->profile_path)}}" target="_blank" class="mt-4 px-6 py-1 transition-all hover:bg-green-600 hover:text-white text-center border-2  border-green-600 inline-block rounded-lg text-green-600  text-sm"> View Profile</a>
                </div>

            </div> --}}

            {{-- <div class="mt-8 px-6">
                <p class="text-2xl text-gray-700 font-simibold"> More Information</p>
                <div class="grid grid-cols-2 gap-8 mt-4">
                    <div>

                   
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">ID Number</p>
                        <p class="text-sm text-gray-800">123123</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Password</p>
                        <p class="text-sm text-gray-800">Passw</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Age</p>
                        <p class="text-sm text-gray-800">21</p>
                    </div>
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48 capitalize">Department</p>
                        <p class="text-sm text-gray-800">Bachellor Biology</p>
                    </div>
                    
                    <div class="flex items-center mt-3 ">
                        <p class="text-sm text-gray-500 mr-4 w-48">Course</p>
                        <p class="text-sm text-gray-800">Alphdasd</p>
                    </div>
                   
                </div>
                <div>
                </div>
                </div>
            </div>
             --}}

            <main class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                <div class="flex justify-end ">

                    {{-- <a href="{{ url()->previous() }}" class=" inline-flex items-center transition-all rounded-lg border-2 border-gray-600 pt-0.5 pb-1 px-4 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                          </svg>
                          
                        <p class="text-xl font-bold tracking-tight text-gray-600 p-0 m-0 capitalize">Back</p>
                    </a> --}}
                </div>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 capitalize">{{$account->last_name}}, {{$account->first_name}} {{$account->middle_name}}</h1>

    <div class="mt-2 border-b border-gray-200 pb-5 text-lg sm:flex sm:justify-between">
      <dl class="flex">
        <dt class="text-gray-500">#&nbsp;</dt>
        <dd class="font-bold text-gray-900">{{$account->id_number}}</dd>
        
        <dt class="text-gray-500 capitalize">  &nbsp;( {{$account->role->name ?? ''}} )</dt>
   
      </dl>
      <div class="mt-4 sm:mt-0">
        <a href="{{ url()->previous() }}" class="font-medium text-gray-600 hover:text-blue-500">
          View More Members
          <span aria-hidden="true"> &rarr;</span>
        </a>
      </div>
    </div>

    <section aria-labelledby="products-heading" class="mt-8">
      <h2 id="products-heading" class="sr-only">Products purchased</h2>

      <div class="space-y-24">
        <div class="grid grid-cols-1 text-sm sm:grid-cols-12 sm:grid-rows-1 sm:gap-x-6 md:gap-x-8 lg:gap-x-8">
          <div class="sm:col-span-4 md:col-span-5 md:row-span-2 md:row-end-2">
            <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg bg-gray-50">
            @if(!empty($account->profile_path))
                <a href="{{Storage::url($account->profile_path)}}" target="_blank">
            
                <img src="{{Storage::url($account->profile_path)}}" alt="Off-white t-shirt with circular dot illustration on the front of mountain ridges that fade." class="object-cover object-center">
            </a>
            @else
            <img src="{{asset('images/placeholder.png')}}" alt="profile" class="object-cover object-center">
            @endif
            </div>
          </div>
          <div class="mt-6 sm:col-span-7 sm:mt-0 md:row-end-1">
            <h3 class="text-lg font-medium text-gray-900 capitalize" >
                    {{$account->department->name ?? ''}} |
                    <span class="text-gray-600 inline-block">{{$account->schoolYear->from }} - {{$account->schoolYear->to }} </span>
            </h3>
            {{-- <p class="mt-1 font-medium text-gray-900 capitalize">            {{$account->role->name ?? ''}}
            </p> --}}
          </div>

          <div class="sm:col-span-12 md:col-span-7">
            @if($account->role->name == 'student')
            <h3 class="text-lg font-medium text-gray-900 capitalize" >
                {{$account->course->name ?? ''}}
        </h3>
            <dl class="grid grid-cols-1 gap-y-8 border-b border-gray-200 py-8 sm:grid-cols-2 sm:gap-x-6 sm:py-6 md:py-10">
              <div>
                <dt class="font-medium text-lg text-gray-900">Guadian</dt>
                <dd class="mt-3  text-gray-500">
                  <p class="block text-md capitalize">{{$account->guardian->first_name}} {{$account->guardian->last_name}}  </p>
                  <p class="block text-md">{{$account->guardian->phone_number}}</p>
                </dd>
              </div>
             
            
            </dl>
            @endif
            {{-- <p class="mt-6 font-medium text-gray-900 md:mt-10">Processing on <time datetime="2021-03-24">March 24, 2021</time></p>
            <div class="mt-6">
              <div class="overflow-hidden rounded-full bg-gray-200">
                <div class="h-2 rounded-full bg-indigo-600" style="width: calc((1 * 2 + 1) / 8 * 100%)"></div>
              </div>
              <div class="mt-6 hidden grid-cols-4 font-medium text-gray-600 sm:grid">
                <div class="text-indigo-600">Order placed</div>
                <div class="text-center text-indigo-600">Processing</div>
                <div class="text-center">Shipped</div>
                <div class="text-right">Delivered</div>
              </div>
            </div> --}}
          </div>

        </div>

      </div>
    </section>

    <!-- Billing -->
    {{-- <section aria-labelledby="summary-heading" class="mt-24">
      <h2 id="summary-heading" class="sr-only">Billing Summary</h2>

      <div class="rounded-lg bg-gray-50 px-6 py-6 lg:grid lg:grid-cols-12 lg:gap-x-8 lg:px-0 lg:py-8">
        <dl class="grid grid-cols-1 gap-6 text-sm sm:grid-cols-2 md:gap-x-8 lg:col-span-5 lg:pl-8">
          <div>
            <dt class="font-medium text-gray-900">Billing address</dt>
            <dd class="mt-3 text-gray-500">
              <span class="block">Floyd Miles</span>
              <span class="block">7363 Cynthia Pass</span>
              <span class="block">Toronto, ON N3Y 4H8</span>
            </dd>
          </div>
          <div>
            <dt class="font-medium text-gray-900">Payment information</dt>
            <dd class="mt-3 flex">
              <div>
                <svg aria-hidden="true" width="36" height="24" viewBox="0 0 36 24" class="h-6 w-auto">
                  <rect width="36" height="24" rx="4" fill="#224DBA" />
                  <path d="M10.925 15.673H8.874l-1.538-6c-.073-.276-.228-.52-.456-.635A6.575 6.575 0 005 8.403v-.231h3.304c.456 0 .798.347.855.75l.798 4.328 2.05-5.078h1.994l-3.076 7.5zm4.216 0h-1.937L14.8 8.172h1.937l-1.595 7.5zm4.101-5.422c.057-.404.399-.635.798-.635a3.54 3.54 0 011.88.346l.342-1.615A4.808 4.808 0 0020.496 8c-1.88 0-3.248 1.039-3.248 2.481 0 1.097.969 1.673 1.653 2.02.74.346 1.025.577.968.923 0 .519-.57.75-1.139.75a4.795 4.795 0 01-1.994-.462l-.342 1.616a5.48 5.48 0 002.108.404c2.108.057 3.418-.981 3.418-2.539 0-1.962-2.678-2.077-2.678-2.942zm9.457 5.422L27.16 8.172h-1.652a.858.858 0 00-.798.577l-2.848 6.924h1.994l.398-1.096h2.45l.228 1.096h1.766zm-2.905-5.482l.57 2.827h-1.596l1.026-2.827z" fill="#fff" />
                </svg>
                <p class="sr-only">Visa</p>
              </div>
              <div class="ml-4">
                <p class="text-gray-900">Ending with 4242</p>
                <p class="text-gray-600">Expires 02 / 24</p>
              </div>
            </dd>
          </div>
        </dl>

        <dl class="mt-8 divide-y divide-gray-200 text-sm lg:col-span-7 lg:mt-0 lg:pr-8">
          <div class="flex items-center justify-between pb-4">
            <dt class="text-gray-600">Subtotal</dt>
            <dd class="font-medium text-gray-900">$72</dd>
          </div>
          <div class="flex items-center justify-between py-4">
            <dt class="text-gray-600">Shipping</dt>
            <dd class="font-medium text-gray-900">$5</dd>
          </div>
          <div class="flex items-center justify-between py-4">
            <dt class="text-gray-600">Tax</dt>
            <dd class="font-medium text-gray-900">$6.16</dd>
          </div>
          <div class="flex items-center justify-between pt-4">
            <dt class="font-medium text-gray-900">Order total</dt>
            <dd class="font-medium text-indigo-600">$83.16</dd>
          </div>
        </dl>
      </div>
    </section> --}}
  </main>
          
        </x-content>

    </section>





</x-main-layout>
