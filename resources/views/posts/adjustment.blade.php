<li class="list-group-item">
    <a href="">{{ $adjustment->user->name }}</a> on <strong>{{ $adjustment->created_at}}</strong> changed<br>
    <table class="table table-condensed table-bordered">
        <tr>
            <th>Field</th>
            <th>Before</th>
            <th>After</th>
        </tr>
        @foreach($adjustment->changedData() as $key => $value)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $value['before']}}</td>
                <td>{{ $value['after']}}</td>
            </tr>
        @endforeach
    </table>
</li>
