@extends('Emails.Layouts.Master')

@section('message_content')
    Hello,<br><br>

    Your refund request for order: <b>{{$order->order_reference}} </b>was denied.<br><br>

    <br><br>
    Thank you
@stop
