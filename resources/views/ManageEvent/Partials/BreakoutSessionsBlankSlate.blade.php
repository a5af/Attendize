@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-calendar
@stop

@section('blankslate-title')
    No BreakoutSessions Yet
@stop

@section('blankslate-text')
    Create first breakout session by clicking the button below.
@stop

@section('blankslate-body')
    <button data-invoke="modal" data-modal-id='CreateBreakoutSessions' data-href="{{route('showCreateBreakoutSession', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
        <i class="ico-calendar"></i>
        Create Breakout Session
    </button>
@stop
