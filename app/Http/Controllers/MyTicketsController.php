<?php

namespace App\Http\Controllers;

use App\Models\BreakoutSession;
use Guzzle\Http\Exception\RequestException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Attendee;
use App\Http\Requests;
use GuzzleHttp\Client;
use Excel;
use Auth;
use Log;
use Validator;

class MyTicketsController extends MyBaseController
{
    /**
     * Show the my tickets list
     *
     * @param Request $request
     * @param $event_id
     * @return View
     */
    public function showMyTickets(Request $request, $event_id = '')
    {
        $allowed_sorts = ['first_name', 'email', 'ticket_id', 'order_reference'];

        $searchQuery = $request->get('q');
        $sort_order = $request->get('sort_order') == 'asc' ? 'asc' : 'desc';
        $sort_by = (in_array($request->get('sort_by'), $allowed_sorts) ? $request->get('sort_by') : 'created_at');

        $event = Event::scope()->find($event_id);

        if ($searchQuery) {
            $myTickets = $event->attendees()
                ->withoutCancelled()
                ->join('orders', 'orders.id', '=', 'attendees.order_id')
                ->where(function ($query) use ($searchQuery) {
                    $query->where('attendees.purchased_by', Auth::user()->id)
                        ->orWhere('attendees.assigned_to', Auth::user()->email)
                        ->orWhere('attendees.assigned_to', Auth::user()->agentcode? Auth::user()->agentcode: 'N/A')
                        ->where('orders.order_reference', 'like', $searchQuery . '%')
                        ->orWhere('attendees.first_name', 'like', $searchQuery . '%')
                        ->orWhere('attendees.email', 'like', $searchQuery . '%')
                        ->orWhere('attendees.last_name', 'like', $searchQuery . '%');
                })
                ->orderBy(($sort_by == 'order_reference' ? 'orders.' : 'attendees.') . $sort_by, $sort_order)
                ->select('attendees.*', 'orders.order_reference')
                ->paginate();
        } else {
            $myTickets = $event->attendees()
                ->where('attendees.purchased_by', Auth::user()->id)
                ->orWhere('attendees.assigned_to', Auth::user()->email)
                ->orWhere('attendees.assigned_to', Auth::user()->agentcode? Auth::user()->agentcode: 'N/A')
                ->withoutCancelled()
                ->join('orders', 'orders.id', '=', 'attendees.order_id')
                ->orderBy(($sort_by == 'order_reference' ? 'orders.' : 'attendees.') . $sort_by, $sort_order)
                ->select('attendees.*', 'orders.order_reference')
                ->paginate();
        }

        $data = [
            'attendees'  => $myTickets,
            'event'      => $event,
            'sort_by'    => $sort_by,
            'sort_order' => $sort_order,
            'q'          => $searchQuery ? $searchQuery : '',
        ];

        return view('ManageEvent.MyTickets', $data);
    }

    /**
     * Show the assign ticket modal
     *
     * @param $attendee_id
     * @return \Illuminate\Contracts\View\View
     */
    public function showAssignTicket($event_id = '',$attendee_id = '')
    {
        $client = new Client();
        $token = session()->get('sso_token');

        // get user's down line
        try {
            $response = $client->get(config('app.bns_url').'/api/myprofile/masteragency?include=userDetail',[
                'headers' => ['Authorization' => 'Bearer '.$token]
            ])->getBody();
        }catch (RequestException $e) {
            return response()->json([
                'status'   => 'error',
                'messages' => 'Something went wrong.',
            ]);
        }

        $data = json_decode($response)->data;
        $bns_users = [];
        for($i = 1; $i < count($data); $i++) {
            array_push($bns_users, $data[$i]->username);
        }

        $data = [
            'event_id'    => $event_id,
            'attendee_id' => $attendee_id,
            'bns_users'   => $bns_users
        ];
        return view('ManageEvent.Modals.AssignTicket', $data);
    }

    /**
     * assign ticket
     * @param Request $request
     * @param $event_id
     * @param $attendee_id
     * @return mixed
     */
    public function postAssignTicket(Request $request, $event_id = '', $attendee_id = '')
    {
        $rules = [
            'assigned_to' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $attendee = Attendee::scope()->find($attendee_id);
        $attendee->assigned_to = $request->get('assigned_to');
        $attendee->update();
        session()->flash('message', 'Successfully assigned tickets.');

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => route('showMyTickets', [
                'event_id' => $event_id,
            ]),
        ]);
    }

    /**
     * Show the join breakout session modal
     *
     * @param $event_id
     * @param $attendee_id
     * @return \Illuminate\Contracts\View\View
     */
    public function showJoinBreakoutSession($event_id = '',$attendee_id = '')
    {
        $event = Event::scope()->find($event_id);
        $breakoutSessions = $event->breakoutSessions
            ->where('is_live', 1);
        foreach ($breakoutSessions as $breakoutSession) {
            $breakoutSession->setAttribute('availability', 'Available');
            $breakoutSessionAttendees = [];
            foreach($breakoutSession->attendees as $attendee) {
                array_push($breakoutSessionAttendees, $attendee->id);
            }

            if (in_array($attendee_id,$breakoutSessionAttendees)) {
                $breakoutSession->availability = 'Joined';
            }else {
                if ($breakoutSession->capacity === $breakoutSession->number_of_subscribers) {
                    $breakoutSession->availability = 'Full';
                }
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s',
                    $breakoutSession->start_date);
                if(Carbon::now()->gte($start_date)) {
                    $breakoutSession->availability = 'Started';
                }
            }

        }

        $data = [
            'event_id'    => $event_id,
            'attendee_id' => $attendee_id,
            'breakoutSessions' => $breakoutSessions,
        ];
        return view('ManageEvent.Modals.JoinBreakoutSession', $data);
    }

    /**
     * join breakout session
     * @param Request $request
     * @param $event_id
     * @param $attendee_id
     * @return mixed
     */
    public function postJoinBreakoutSession(Request $request, $event_id = '', $attendee_id = '')
    {
        $attendee = Attendee::find($attendee_id);

        $selectedBreakoutSessions = BreakoutSession::find($request->get('breakoutSessions'));
        if($selectedBreakoutSessions) {
            //check time overlapping
            foreach ($selectedBreakoutSessions as $breakoutSession) {
                foreach ($selectedBreakoutSessions as $compare) {
                    if($breakoutSession == $compare)
                        continue;
                    if($this->checkDateTimeOverlapping($breakoutSession, $compare))
                        return response()->json([
                            'status'   => 'error',
                            'messages' => [
                                'overlap_error' => 'You can not attend many breakout session at the same time.'
                            ],
                        ]);
                }

                foreach ($attendee->breakoutSessions as $compare) {
                    if($this->checkDateTimeOverlapping($breakoutSession, $compare))
                        return response()->json([
                            'status'   => 'error',
                            'messages' => [
                                'overlap_error' => 'You can not attend many breakout session at the same time.'
                            ],
                        ]);
                }
            }

            $attendee->breakoutSessions()->attach($selectedBreakoutSessions);
            foreach ($selectedBreakoutSessions as $breakoutSession) {
                $breakoutSession->number_of_subscribers++;
                $breakoutSession->update();
            }
            session()->flash('message', 'Successfully joined to breakout sessions.');
        }
        return response()->json([
            'status'      => 'success',
            'redirectUrl' => route('showMyTickets', [
                'event_id' => $event_id,
            ]),
        ]);
    }

    /**
     * @param $obj1
     * @param $obj2
     * @return boolean
     */
    public function checkDateTimeOverlapping($obj1, $obj2) {
        $start_date1 = Carbon::createFromFormat('Y-m-d H:i:s',
            $obj1->start_date);
        $end_date1 = Carbon::createFromFormat('Y-m-d H:i:s',
            $obj1->end_date);
        $start_date2 = Carbon::createFromFormat('Y-m-d H:i:s',
            $obj2->start_date);
        $end_date2 = Carbon::createFromFormat('Y-m-d H:i:s',
            $obj2->end_date);
        if($start_date1->lte($end_date2) && $start_date2->lte($end_date1))
            return true;
        return false;
    }
}
