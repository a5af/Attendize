<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postAssignTicket', array('event_id' => $event_id, 'attendee_id'=>$attendee_id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    Assign Ticket</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('assigned_to', 'Equis ID or Guest Email Address', array('class'=>'control-label required')) !!}
                            {!!  Form::text('assigned_to', Input::old('assigned_to'),
                                        array(
                                        'class'=>'form-control',
                                        'placeholder'=>'E.g: EF123456',
                                        'list' => 'emails'
                                        ))  !!}
                            <datalist id="emails">
                                @foreach($bns_users as $bns_user)
                                    <option value="{{$bns_user}}">
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('Assign Ticket', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>