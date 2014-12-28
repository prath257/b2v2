<!DOCTYPE html>
<html>

<head>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
    }
    th {
        text-align: left;
    }
</style>
</head>

<body>

Here's your list.<br>
<br>
<hr>

<table style="width:100%">
    <tr>
        <th>Name</th>
        <th>E-mail</th>
        <th>Contact No.</th>
    </tr>
    @foreach($attendees as $a)
    <tr>
        <td>{{$a->first_name}} {{$a->last_name}}</td>
        <td>{{$a->email}}</td>
        <?php $number = DB::table('guest_list')->where('event_id',$event->id)->where('user_id',$a->id)->pluck('contact_no'); ?>
        <td>{{$number}}</td>
    </tr>
    @endforeach
</table>

<hr>
<br><br>
Regards,<br>
Team BBarters.

</body>
</html>
