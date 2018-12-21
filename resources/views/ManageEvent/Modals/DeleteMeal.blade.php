<div role="dialog"  class="modal fade " style="display: none;">
   {!! Form::model($meal, array('url' => route('postDeleteMeal', array('event_id' => $event->id, 'meal_id' => $meal->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-cancel"></i>
                    Delete Meal Option</h3>
            </div>
            <div class="modal-body">
                <h3 class="text-center">
                    Do you want to delete this meal option?
                </h3>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('Delete', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>

