<div class="px-4">
    <div class="flex items-center justify-between mt-6 mb-4">
        <div class="flex items-center ">
            <p class="text-xl text-gray-800 p-0 mr-4 ">
                Realtime Recording
                
            </p>
            <svg xmlns="http://www.w3.org/2000/svg" class="p-0 w-8 h-8 mt-1" fill="none" viewBox="0 0 24 24" id="live-streaming"><path fill="#EE4D4D" d="M12 8.75C10.2051 8.75 8.75 10.2051 8.75 12C8.75 13.7949 10.2051 15.25 12 15.25C13.7949 15.25 15.25 13.7949 15.25 12C15.25 10.2051 13.7949 8.75 12 8.75Z"></path><path fill="#EE4D4D" fill-rule="evenodd" d="M8.63374 7.46227C8.93072 7.75101 8.93739 8.22584 8.64865 8.52282C6.78378 10.4409 6.78378 13.5591 8.64865 15.4772C8.93739 15.7742 8.93072 16.249 8.63374 16.5377C8.33675 16.8265 7.86193 16.8198 7.57318 16.5228C5.14227 14.0226 5.14227 9.97741 7.57318 7.47718C7.86193 7.1802 8.33675 7.17352 8.63374 7.46227ZM15.3663 7.46227C15.6632 7.17352 16.1381 7.1802 16.4268 7.47718C18.8577 9.97741 18.8577 14.0226 16.4268 16.5228C16.1381 16.8198 15.6632 16.8265 15.3663 16.5377C15.0693 16.249 15.0626 15.7742 15.3514 15.4772C17.2162 13.5591 17.2162 10.4409 15.3514 8.52282C15.0626 8.22584 15.0693 7.75101 15.3663 7.46227Z" clip-rule="evenodd"></path><path fill="#EE4D4D" fill-rule="evenodd" d="M6.52038 5.47013C6.81302 5.76328 6.81261 6.23815 6.51946 6.53079C3.49351 9.5515 3.49351 14.4485 6.51946 17.4692C6.81261 17.7619 6.81302 18.2367 6.52038 18.5299C6.22774 18.823 5.75287 18.8234 5.45972 18.5308C1.84676 14.9241 1.84676 9.07592 5.45972 5.46921C5.75287 5.17657 6.22774 5.17698 6.52038 5.47013ZM17.4796 5.47013C17.7723 5.17698 18.2471 5.17657 18.5403 5.46921C22.1532 9.07592 22.1532 14.9241 18.5403 18.5308C18.2471 18.8234 17.7723 18.823 17.4796 18.5299C17.187 18.2367 17.1874 17.7619 17.4805 17.4692C20.5065 14.4485 20.5065 9.5515 17.4805 6.53079C17.1874 6.23815 17.187 5.76328 17.4796 5.47013Z" clip-rule="evenodd"></path></svg>

        </div>
        <div class="flex items-center ">
            <svg xmlns="http://www.w3.org/2000/svg"  class="p-0 w-8 h-8 mt-1 mr-4"  viewBox="0 0 64.88 62.43" id="calendar"><g data-name="Layer 2"><path fill="#b76a8a" d="M59.88 16.43h-49v41a5 5 0 0 0 5 5h44a5 5 0 0 0 5-5v-36a5 5 0 0 0-5-5z" opacity=".15"></path><rect width="54" height="46" x="2.5" y="7.43" fill="none" stroke="#6a80b9" stroke-miterlimit="10" stroke-width="5" rx="2" ry="2"></rect><path fill="none" stroke="#6a80b9" stroke-miterlimit="10" stroke-width="3" d="M16.4 0v15.59M29.5 0v15.59M42.6 0v15.59"></path><path fill="none" stroke="#6a80b9" stroke-miterlimit="10" stroke-width="2" d="M2.5 21.66h54"></path><path fill="#6a80b9" d="M27.17 28.1h4.66v4.66h-4.66zM40.27 28.1h4.66v4.66h-4.66zM14.08 28.1h4.66v4.66h-4.66zM27.17 39.83h4.66v4.66h-4.66zM40.27 39.83h4.66v4.66h-4.66zM14.08 39.83h4.66v4.66h-4.66z"></path></g></svg>
            <p class="text-xl text-gray-800 ">
                Date:  

                @if(!empty($todayRecord))
                {{$todayRecord->created_at->format('F d, Y')}}
                @else
                
                {{now()->format('F d, Y')}}
                @endif
            </p>
        </div>
    </div>
  {{ $this->table }}
</div>
