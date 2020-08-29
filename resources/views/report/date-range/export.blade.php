<table>
    <tbody>
    @foreach($data as$index=> $i)
        <tr>
            <td>Work ID No.</td>
            <td>{{$i->work_id_number}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>Departement</td>
            <td>{{$i->work_group_name}}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{$i->name}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>Title</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center; width: 25px;">Shift</td>
            <td style="text-align: center">Day</td>
            <td style="text-align: center">Date In</td>
            <td style="text-align: center">In</td>
            <td style="text-align: center">Date Out</td>
            <td style="text-align: center">Out</td>
        </tr>
        @foreach($i->detail as $d)
            <tr>
                <td>{{$d->shift_name}}</td>
                <td style="text-align: center">{{$d->day}}</td>
                <td style="text-align: center">{{$d->date_in}}</td>
                <td style="text-align: center">{{$d->time_in}}</td>
                <td style="text-align: center">{{$d->date_out}}</td>
                <td style="text-align: center">{{$d->time_out}}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
