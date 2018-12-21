@extends('Shared.Layouts.BlankSlate')


@section('blankslate-icon-class')
    ico-ticket
@stop

@section('blankslate-title')
    No Purchased Ticket Yet
@stop

@section('blankslate-text')
    Tickets will appear here once you successfully purchase tickets for event.
@stop

@section('blankslate-body')
    <a target="_blank" href="<?php echo e($event->event_url); ?>">
        <button class=' btn btn-success mt5 btn-lg' type="button" >
            <i class="ico-ticket"></i>
            Purchase Ticket
        </button>
    </a>
@stop


