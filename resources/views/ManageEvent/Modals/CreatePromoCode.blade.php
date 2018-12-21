<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postCreatePromoCode', array('event_id' => $event->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-scissors"></i>
                    Create Promo Code</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('code', 'Promo Code', array('class'=>'control-label required')) !!}
                            {!!  Form::text('code', Input::old('code'),
                                        array(
                                        'class'=>'form-control',
                                        'placeholder'=>'E.g: 3A31343B'
                                        ))  !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('discount_type', 'Discount Type', array('class'=>'control-label required')) !!}
                            <label class="radio-inline" for="discount_type">
                                <input type="radio" name="discount_type" id="percent_off"
                                       value="0" checked/> Percent Off
                            </label>
                            <label class="radio-inline" for="discount_type">
                                <input type="radio" name="discount_type" id="discount_off"
                                       value="1"/> Discount Off
                            </label>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('discount', 'Discount', array('class'=>'control-label required')) !!}
                                    {!!  Form::text('discount', Input::old('discount'),
                                                array(
                                                'class'=>'form-control',
                                                'placeholder'=> 'E.g: 10(%) or 200('.$event->currency->symbol_left.')'
                                                ))  !!}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('max_redemption', 'Max redemption', array('class'=>' control-label')) !!}
                                    {!!  Form::text('max_redemption', Input::old('max_redemption'),
                                                array(
                                                'class'=>'form-control',
                                                'placeholder'=>'E.g: 100 (Leave blank for unlimited)'
                                                )
                                                )  !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group more-options">
                            {!! Form::label('description', 'Promo code Description', array('class'=>'control-label')) !!}
                            {!!  Form::text('description', Input::old('description'),
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
                        </div>

                        <div class="row more-options">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('start_date', 'Start Date', array('class'=>' control-label')) !!}
                                    {!!  Form::text('start_date', Input::old('start_date'),
                                                    [
                                                'class'=>'form-control start hasDatepicker ',
                                                'data-field'=>'datetime',
                                                'data-startend'=>'start',
                                                'data-startendelem'=>'.end',
                                                'readonly'=>''

                                            ])  !!}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!!  Form::label('end_date', 'End Date',
                                                [
                                            'class'=>' control-label '
                                        ])  !!}
                                    {!!  Form::text('end_date', Input::old('end_date'),
                                            [
                                        'class'=>'form-control end hasDatepicker ',
                                        'data-field'=>'datetime',
                                        'data-startend'=>'end',
                                        'data-startendelem'=>'.start',
                                        'readonly'=>''
                                    ])  !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="javascript:void(0);" class="show-more-options">
                            More Options
                        </a>
                    </div>

                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('Create Promo code', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>