<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postJoinBreakoutSession', array('event_id' => $event_id, 'attendee_id'=>$attendee_id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    Join Breakout Session</h3>
            </div>
            <div class="modal-body">
                <input type="hidden" name="overlap_error">
                <div class="row">
                    @if($breakoutSessions->count())
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="table-responsive ">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Title</th>
                                            <th class="text-center">Attendance</th>
                                            <th>Start date</th>
                                            <th>End date</th>
                                            <th>Availability</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($breakoutSessions as $breakoutSession)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="breakoutSessions[]"
                                                           value="{{$breakoutSession->id}}"
                                                            {{($breakoutSession->availability === 'Available')? '' : 'disabled'}}>
                                                </td>
                                                <td>{{$breakoutSession->title}}</td>
                                                <td class="text-center">{{$breakoutSession->number_of_subscribers}}/{{$breakoutSession->capacity}}</td>
                                                <td>{{$breakoutSession->start_date}}</td>
                                                <td>{{$breakoutSession->end_date}}</td>
                                                <td>
                                                    <span class="label label-{{($breakoutSession->availability === 'Available')? 'success' : 'warning'}}">
                                                        {{$breakoutSession->availability}}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @else
                        <h2 class="text-center">
                            No Breakout Sessions
                        </h2>
                        @endif
                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('Join', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>


