<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Department</th>
        <th>Role</th>
        <th>Course</th>
        <th>Morning</th>
        <th>Afternoon </th>
 
    </tr>
    </thead>
    <tbody>
    @foreach($collections as $item)
        <tr>
            <td width="50">{{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}</td>
            <td width="50">{{ $item->department_name ?? '' }} </td>
            <td width="50">{{ $item->role_name ?? '' }} </td>
            <td width="50">{{ $item->course_name ?? '' }} </td>
            <td width="50">
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
                Did not login
            @else
                NONE
            @endif
         </td>
         <td width="50">
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
            Did not login
        @else
            NONE
        @endif
         </td>
           
        </tr>
    @endforeach
    </tbody>
</table>
