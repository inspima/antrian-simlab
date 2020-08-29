<table>
    <thead>
    <tr>
        <th width="5%" rowspan="2">No</th>
        <th rowspan="2">Name</th>
        @foreach($header as $m)
            <th style="text-align: center" colspan="{{count($m['dates'])}}">{{$m['month']}}</th>
        @endforeach
    </tr>
    <tr>
        @foreach($header as $m)
            @foreach($m['dates'] as $d)
                <th style="text-align: center">{{$d['day']}}</th>
            @endforeach
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($dataPersonals as$index=> $i)
        <tr>
            <td>{{$index+1}}</td>
            <td>{{$i->name}}</td>
            @foreach($header as $m)
                @foreach($m['dates'] as $d)
                    <td style="text-align: center">{{$i['attendances'][$d['date']]}}</td>
                @endforeach
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
