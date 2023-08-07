<table>
    <thead>
    <tr>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($collections as $item)
        <tr>
            <td width="50">{{ $item->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
