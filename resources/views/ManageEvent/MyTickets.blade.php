@extends('Shared.Layouts.Master')

@section('title')
    @parent
    Event Attendees
@stop


@section('page_title')
    <i class="ico-ticket mr5"></i>
    My Tickets
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop


@section('head')

@stop

@section('page_header')
    <div class="col-md-9">
        <div class="btn-toolbar" role="toolbar">
            <a target="_blank" href="<?php echo e($event->event_url); ?>">
                <button class=' btn btn-success' type="button" >
                    <i class="ico-ticket"></i>
                    Purchase Ticket
                </button>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        {!! Form::open(array('url' => route('showMyTickets', ['event_id'=>$event->id,'sort_by'=>$sort_by]), 'method' => 'get')) !!}
        <div class="input-group">
            <input name="q" value="{{$q or ''}}" placeholder="Search Tickets.." type="text" class="form-control" />
            <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
        </div>
        {!! Form::close() !!}
    </div>
@stop


@section('content')

    <!--Start Attendees table-->
    <div class="row">
        <div class="col-md-12">
            @if($attendees->count())
                <div class="panel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>
                                    {!!Html::sortable_link('Ticket Number', $sort_by, 'ticket_id', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                                </th>
                                <th>
                                    {!!Html::sortable_link('Ticket', $sort_by, 'ticket_id', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                                </th>
                                <th>
                                    {!!Html::sortable_link('Owner', $sort_by, 'first_name', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                                </th>
                                <th>
                                    {!!Html::sortable_link('Order date', $sort_by, 'created_at', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                                </th>
                                <th>
                                    {!!Html::sortable_link('Order Ref.', $sort_by, 'order_reference', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                                </th>
                                <th>{!!Html::sortable_link('Assigned To.', $sort_by, 'assigned_to', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}</th>
                                <th>Breakout Session</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($attendees as $attendee)
                                <tr class="attendee_{{$attendee->id}} {{$attendee->is_cancelled ? 'danger' : ''}}">
                                    <td>{{$attendee->private_reference_number}}</td>
                                    <td>{{$attendee->ticket->title}}</td>
                                    <td>{{$attendee->user->full_name}}</td>
                                    <td>{{$attendee->created_at}}</td>
                                    <td>
                                        <a href="javascript:void(0);" data-modal-id="view-order-{{ $attendee->order->id }}" data-href="{{route('showManageOrder', ['order_id'=>$attendee->order->id])}}" title="View Order #{{$attendee->order->order_reference}}" class="loadModal">
                                            {{$attendee->order->order_reference}}
                                        </a>
                                    </td>
                                    <td>{{$attendee->assigned_to ? $attendee->assigned_to: 'N/A'}}</td>
                                    <td class="text-center">
                                        <a data-modal-id="JoinBreakoutSession" data-href="{{route('showJoinBreakoutSession', ['event_id'=>$event->id, 'attendee_id'=>$attendee->id])}}" class="btn btn-xs btn-primary loadModal">{{$attendee->joinedBreakoutSession()? 'Registered' : 'Join Now'}}</a>
                                    </td>
                                    @if($attendee->purchased_by === Auth::user()->id)
                                        <td class="">
                                            <a data-modal-id="AssignTicket" data-href="{{route('showAssignTicket', ['event_id'=>$event->id, 'attendee_id'=>$attendee->id])}}" class="btn btn-xs btn-primary loadModal">Assign</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else

                @if(!empty($q))
                    @include('Shared.Partials.NoSearchResults')
                @else
                    @include('ManageEvent.Partials.MyTicketsBlankSlate')
                @endif

            @endif
        </div>
        <div class="col-md-12">
            {!!$attendees->appends(['sort_by' => $sort_by, 'sort_order' => $sort_order, 'q' => $q])->render()!!}
        </div>
    </div>    <!--/End attendees table-->

@stop


