<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Nomor registrasi</th>
            <th>Nama</th>
            <th>No. Handphone</th>
            <th>Sektor</th>
            <th>Present</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activity_registrations as $activity)
            <tr>
                <td>{{++$i}}</td>  
                <td>{{$activity->registration_number}}</td>
                <td>{{$activity->user->name}}</td>
                <td>{{$activity->user->phone_number()}}</td>
                <td>{{$activity->user->sektor()}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>