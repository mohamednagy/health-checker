<h3>Health Check Result:</h3>
<br>
<table>
    <tr>
        <th>Checker</th>
        <th>status</th>
        <th>message</th>
    </tr>

    @foreach($resultCollection as $result)
        <tr>
            <td>$result['checkerName]</td>
            <td>$result['status']</td>
            <td>$result['message]</td>
        </tr>
    @endforeach
</table>
