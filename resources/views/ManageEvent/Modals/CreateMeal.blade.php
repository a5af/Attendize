<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postCreateMeal', array('event_id' => $event->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-food3"></i>
                    Create Meal</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="type">
                                Meal Type
                            </label>

                            <select id="type" class="form-control" name="type">
                                <option value="Breakfast">Breakfast</option>
                                <option value="Brunch">Brunch</option>
                                <option value="Lunch">Lunch</option>
                                <option value="Snack">Snack</option>
                                <option value="Dinner">Dinner</option>
                                <option value="Dessert">Dessert</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date" class="required">Date</label>
                            {!!  Form::text('date', Input::old('date'),
                                            [
                                        'class'=>'form-control start hasDatepicker ',
                                        'data-field'=>'date',
                                        'data-min' => $event->start_date,
                                        'data-max' => $event->end_date,
                                        'data-format' => 'yyyy-MM-dd',
                                        'readonly'=> ''
                            ])  !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="option" class="required">Option</label>
                            {!!  Form::text('option', Input::old('option'),
                                                array(
                                                'class'=>'form-control',
                                                'placeholder'=>'Ham Sandwich w/Chips'
                                                ))  !!}
                        </div>
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('Create Meal', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
