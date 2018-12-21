@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-scissors
@stop

@section('blankslate-title')
    No PromoCodes Yet
@stop

@section('blankslate-text')
    Create your first promo-codes by clicking the button below.
@stop

@section('blankslate-body')
    <button data-invoke="modal" data-modal-id='CreatePromoCode' data-href="{{route('showCreatePromoCode', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
        <i class="ico-scissors"></i>
        Create PromoCode
    </button>
@stop
