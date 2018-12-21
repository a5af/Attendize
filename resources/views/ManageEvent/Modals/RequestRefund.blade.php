<div role="dialog"  class="modal fade " style="display: none;">
   {!! Form::open(array('url' => route('postRequestRefund', array('order_id' => $order_id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Request Refund</h3>
            </div>
            <div class="modal-body">
                <h3 class="text-center">
                    Do you want to refund this order?
                </h3>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button('Close', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('Refund Request', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>

