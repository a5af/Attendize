@extends('Shared.Layouts.Master')

@section('title')
    @parent
    Promo Codes
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('page_title')
    <i class='ico-scissors mr5'></i>
    Promo Codes
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
                        data-href="{{route('showCreatePromoCode', array('event_id'=>$event->id))}}"
                        class='loadModal btn btn-success' type="button"><i class="ico-scissors"></i> Create Promo Code
                </button>
            </div>

            <div class="btn-group btn-group-responsive">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="ico-users"></i> Export <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{route('showExportPromoCodes', ['event_id'=>$event->id,'export_as'=>'xlsx'])}}">Excel (XLSX)</a></li>
                    <li><a href="{{route('showExportPromoCodes', ['event_id'=>$event->id,'export_as'=>'xls'])}}">Excel (XLS)</a></li>
                    <li><a href="{{route('showExportPromoCodes', ['event_id'=>$event->id,'export_as'=>'csv'])}}">CSV</a></li>
                    <li><a href="{{route('showExportPromoCodes', ['event_id'=>$event->id,'export_as'=>'html'])}}">HTML</a></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="col-md-3">
        {!! Form::open(array('url' => route('showPromoCodes', ['event_id'=>$event->id,'sort_by'=>$sort_by]), 'method' => 'get')) !!}
        <div class="input-group">
            <input name="q" value="{{$q or ''}}" placeholder="Search PromoCode.." type="text" class="form-control" />
            <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
        </div>
        {!! Form::close() !!}
    </div>
@stop


@section('content')
    <div class="row sortable">
        @if($promoCodes->count())
            <div class="col-md-12">
                <div class="panel">
                    <div class="table-responsive ">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>
                                    {!! Html::sortable_link('Code.', $sort_by, 'code', $sort_order, ['q' => $q , 'page' => $promoCodes->currentPage()]) !!}
                                </th>
                                <th>
                                    Terms
                                </th>
                                <th class="text-center">
                                    {!! Html::sortable_link('Redemption', $sort_by, 'number_of_uses', $sort_order, ['q' => $q , 'page' => $promoCodes->currentPage()]) !!}
                                </th>
                                <th>
                                    {!! Html::sortable_link('Start date', $sort_by, 'start_date', $sort_order, ['q' => $q , 'page' => $promoCodes->currentPage()]) !!}
                                </th>
                                <th>
                                    {!! Html::sortable_link('End date', $sort_by, 'end_date', $sort_order, ['q' => $q , 'page' => $promoCodes->currentPage()]) !!}
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($promoCodes as $promoCode)
                                <tr>
                                    <td>{{$promoCode->code}}</td>
                                    <td>{{$promoCode->discount_type === 0 ? $promoCode->discount."% off" :money($promoCode->discount, $event->currency)." off"}}</td>
                                    <td class="text-center">{{$promoCode->number_of_uses."/".($promoCode->max_redemption === 0 ?  "-" : $promoCode->max_redemption)}}</td>
                                    <td>{{$promoCode->start_date ? $promoCode->start_date : 'N/A'}}</td>
                                    <td>{{$promoCode->end_date? $promoCode->end_date: 'N/A'}}</td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
            <div class="col-md-12">
                {!!$promoCodes->appends(['sort_by' => $sort_by, 'sort_order' => $sort_order, 'q' => $q])->render()!!}
            </div>
        @else
            @if(!empty($q))
                @include('Shared.Partials.NoSearchResults')
            @else
                @include('ManageEvent.Partials.PromoCodesBlankSlate')
            @endif
        @endif
    </div>

@stop
