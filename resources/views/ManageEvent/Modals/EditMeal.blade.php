<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postEditMeal', array('event_id' => $event->id, 'meal_id' => $meal->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-edit"></i>
                    Edit Meal</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="type">
                                Meal Type
                            </label>

                            <select id="type" class="form-control" name="type">
                                @foreach($types as $type)
                                    <option value={{$type}}
                                    @if ($type == $meal->type)
                                            selected="selected"
                                    @endif
                                    >{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date" class="required">Date</label>
                            {!!  Form::text('date', $meal->date,
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
                            {!!  Form::text('option', $meal->option,
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
               {!! Form::submit('Update', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>