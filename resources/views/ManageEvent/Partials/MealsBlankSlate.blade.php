@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-food3
@stop

@section('blankslate-title')
    No Meals Yet
@stop

@section('blankslate-text')
    Create a meal by clicking the button below.
@stop

@section('blankslate-body')
    <button data-invoke="modal" data-modal-id='CreateMeal' data-href="{{route('showCreateMeal', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
        <i class="ico-food3"></i>
        Create Meal
    </button>
@stop
