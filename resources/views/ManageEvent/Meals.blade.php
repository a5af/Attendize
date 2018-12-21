@extends('Shared.Layouts.Master')

@section('title')
    @parent
    Meals
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('page_title')
    <i class='ico-food3 mr5'></i>
    Meals
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
                        data-href="{{route('showCreateMeal', array('event_id'=>$event->id))}}"
                        class='loadModal btn btn-success' type="button"><i class="ico-food3"></i> Create Meal
                </button>
            </div>

        </div>
    </div>

@stop


@section('content')
    <div class="row sortable">
        @if($meals->count())
            <div class="col-md-12">
                <div class="panel">
                    <div class="table-responsive ">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>
                                    {!! Html::sortable_link('Meal Type', $sort_by, 'type', $sort_order, ['page' => $meals->currentPage()]) !!}
                                </th>
                                <th>
                                    {!! Html::sortable_link('Date', $sort_by, 'date', $sort_order, ['page' => $meals->currentPage()]) !!}
                                </th>
                                <th>
                                   Option
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($meals as $meal)
                                <tr>
                                    <td>{{$meal->type}}</td>
                                    <td>{{$meal->date}}</td>
                                    <td>{{$meal->option}}</td>
                                    <td>
                                        <a data-modal-id="EditMeal"
                                           href="javascript:void(0);"
                                           data-href="{{route('showEditMeal', ['event_id'=>$event->id, 'meal_id' => $meal->id])}}"
                                           class="loadModal btn btn-xs btn-primary"> Edit</a>
                                        <a data-modal-id="DeleteBreakoutSession"
                                           href="javascript:void(0);"
                                           data-href="{{route('showDeleteMeal', ['event_id'=>$event->id, 'meal_id' =>$meal->id])}}"
                                           class="loadModal btn btn-xs btn-danger"> Delete</a>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    {!!$meals->appends(['sort_by' => $sort_by, 'sort_order' => $sort_order])->render()!!}
                </div>
                @else
                    @include('ManageEvent.Partials.MealsBlankSlate')
                @endif
            </div>
    </div>

@stop
