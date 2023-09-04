<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Middle Name</th>
        <th>Role Name</th>
        <th>School Year</th>
        <th>Department Name</th>
        <th>Course Name</th>
        <th>Section</th>
    </tr>
    </thead>
    <tbody>
    @foreach($collections as $item)
        <tr>
            <td width="50">{{ $item->id ?? ''}}</td>
            <td width="50">{{ $item->first_name ?? ''}}</td>
            <td width="50">{{ $item->last_name ?? ''}}</td>
            <td width="50">{{ $item->middle_name ?? ''}}</td>
            <td width="50">{{ $item->role->name ?? ''}}</td>
            <td width="50">{{ $item->schoolYear->from ?? ''}} - {{ $item->schoolYear->to ?? ''}}</td>
            <td width="50">{{ optional($item->deparment)->name ?? ''}}</td>
            <td width="50">{{ optional($item->course)->name ?? ''}}</td>
            <td width="50">{{ optional($item->section)->name ?? ''}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
