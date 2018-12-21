<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postEditBreakoutSession', array('event_id' => $event->id, 'breakout_session_id' => $breakoutSession->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-edit"></i>
                    Edit <b>{{$breakoutSession->title}} </b></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('title', 'Title', array('class'=>'control-label required')) !!}
                            {!!  Form::text('title', $breakoutSession->title,
                                        array(
                                        'class' => 'form-control',
                                        ))  !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', array('class'=>'control-label required')) !!}
                            {!!  Form::text('description', $breakoutSession->description,
                                        array(
                                        'class' => 'form-control',
                                        ))  !!}
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('capacity', 'Capacity', array('class'=>' control-label required')) !!}
                                    {!!  Form::text('capacity', $breakoutSession->capacity,
                                                array(
                                                'class' => 'form-control',
                                                'placeholder' => 'E.g: 100',
                                                ))  !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('start_date', 'Start Date', array('class'=>' control-label required')) !!}
                                    {!!  Form::text('start_date', substr($breakoutSession->start_date, 0, -3),
                                                    [
                                                'class'=>'form-control start hasDatepicker ',
                                                'data-field'=>'datetime',
                                                'data-startend'=>'start',
                                                'data-startendelem'=>'.end',
                                                'data-min' => $event->start_date,
                                                'data-max' => $event->end_date,
                                                'data-format' => 'yyyy-MM-dd HH:mm',
                                                'readonly'=>''
                                            ])  !!}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!!  Form::label('end_date', 'End Date',
                                                [
                                            'class'=>' control-label required'
                                        ])  !!}
                                    {!!  Form::text('end_date', substr($breakoutSession->end_date, 0, -3),
                                            [
                                        'class'=>'form-control end hasDatepicker ',
                                        'data-field'=>'datetime',
                                        'data-startend'=>'end',
                                        'data-startendelem'=>'.start',
                                        'data-min' => $event->start_date,
                                        'data-max' => $event->end_date,
                                        'data-format' => 'yyyy-MM-dd HH:mm',
                                        'readonly'=>''
                                    ])  !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('Update', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>