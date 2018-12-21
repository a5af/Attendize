@extends('Shared.Layouts.Master')

@section('title')
    @parent
    Breakout Sessions
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('page_title')
    <i class='ico-calendar mr5'></i>
    Breakout Sessions
@stop

@section('head')

@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_header')
    <div class="col-md-9">
        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group btn-group-responsive">
                <button data-modal-id='CreatePromoCode'
                        data-href="{{route('showCreateBreakoutSession', array('event_id'=>$event->id))}}"
                        class='loadModal btn btn-success' type="button"><i class="ico-calendar"></i> Create Breakout Session
                </button>
            </div>

            <div class="btn-group btn-group-responsive">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="ico-users"></i> Export <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{route('showExportBreakoutSession', ['event_id'=>$event->id,'export_as'=>'xlsx'])}}">Excel (XLSX)</a></li>
                    <li><a href="{{route('showExportBreakoutSession', ['event_id'=>$event->id,'export_as'=>'xls'])}}">Excel (XLS)</a></li>
                    <li><a href="{{route('showExportBreakoutSession', ['event_id'=>$event->id,'export_as'=>'csv'])}}">CSV</a></li>
                    <li><a href="{{route('showExportBreakoutSession', ['event_id'=>$event->id,'export_as'=>'html'])}}">HTML</a></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="col-md-3">
        {!! Form::open(array('url' => route('showBreakoutSessions', ['event_id'=>$event->id,'sort_by'=>$sort_by]), 'method' => 'get')) !!}
        <div class="input-group">
            <input name="q" value="{{$q or ''}}" placeholder="Search Breakout Session.." type="text" class="form-control" />
            <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
        </div>
        {!! Form::close() !!}
    </div>
@stop


@section('content')
    <div class="row sortable">
        @if($breakoutSessions->count())
            <div class="col-md-12">
                <div class="panel">
                    <div class="table-responsive ">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>
                                    {!! Html::sortable_link('Title', $sort_by, 'title', $sort_order, ['q' => $q , 'page' => $breakoutSessions->currentPage()]) !!}
                                </th>
                                <th class="text-center">
                                    {!! Html::sortable_link('Capacity', $sort_by, 'capacity', $sort_order, ['q' => $q , 'page' => $breakoutSessions->currentPage()]) !!}
                                </th>
                                <th class="text-center">
                                    {!! Html::sortable_link('Number of Subscribers', $sort_by, 'number_of_subscribers', $sort_order, ['q' => $q , 'page' => $breakoutSessions->currentPage()]) !!}
                                </th>
                                <th>
                                    {!! Html::sortable_link('Start date', $sort_by, 'start_date', $sort_order, ['q' => $q , 'page' => $breakoutSessions->currentPage()]) !!}
                                </th>
                                <th>
                                    {!! Html::sortable_link('End date', $sort_by, 'end_date', $sort_order, ['q' => $q , 'page' => $breakoutSessions->currentPage()]) !!}
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($breakoutSessions as $breakoutSession)
                                <tr>
                                    <td>{{$breakoutSession->title}}</td>
                                    <td class="text-center">{{$breakoutSession->capacity}}</td>
                                    <td class="text-center">{{$breakoutSession->number_of_subscribers}}</td>
                                    <td>{{$breakoutSession->start_date}}</td>
                                    <td>{{$breakoutSession->end_date}}</td>
                                    <td>
                                        <a data-modal-id="EditBreakoutSession"
                                           href="javascript:void(0);"
                                           data-href="{{route('showEditBreakoutSession', ['event_id'=>$event->id, 'breakout_session_id' => $breakoutSession->id])}}"
                                           class="loadModal btn btn-xs btn-primary"> Edit</a>
                                        <a data-modal-id="DeleteBreakoutSession"
                                           href="javascript:void(0);"
                                           data-href="{{route('showDeleteBreakoutSession', ['event_id'=>$event->id, 'breakout_session_id'=>$breakoutSession->id])}}"
                                           class="loadModal btn btn-xs btn-danger"> Delete</a>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    {!!$breakoutSessions->appends(['sort_by' => $sort_by, 'sort_order' => $sort_order, 'q' => $q])->render()!!}
                </div>
                @else
                    @if(!empty($q))
                        @include('Shared.Partials.NoSearchResults')
                    @else
                        @include('ManageEvent.Partials.BreakoutSessionsBlankSlate')
                    @endif
                @endif
            </div>
    </div>

@stop
