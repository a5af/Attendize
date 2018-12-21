<?php

namespace App\Http\Controllers;

use App\Models\BreakoutSession;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Http\Requests;
use Excel;
use Auth;

class EventBreakoutSessionsController extends MyBaseController
{
    /**
     * @param Request $request
     * @param string $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBreakoutSessions(Request $request, $event_id = '')
    {
        $allowed_sorts = ['title', 'capacity', 'start_date', 'end_date','is_live', 'number_of_subscribers'];

        $searchQuery = $request->get('q');
        $sort_by = (in_array($request->get('sort_by'), $allowed_sorts) ? $request->get('sort_by') : 'created_at');
        $sort_order = $request->get('sort_order') == 'asc' ? 'asc' : 'desc';
        $event = Event::scope()->find($event_id);

        if ($searchQuery) {
            /*
             * Strip the hash from the start of the search term in case people search for
             * order references like '#EDGC67'
             */
            if ($searchQuery[0] === '#') {
                $searchQuery = str_replace('#', '', $searchQuery);
            }

            $breakoutSessions = $event->breakoutSessions()
                ->where(function ($query) use ($searchQuery) {
                    $query->where('title', 'like', $searchQuery . '%');
                })
                ->orderBy($sort_by, $sort_order)
                ->paginate();
        } else {
            $breakoutSessions = $event->breakoutSessions()->orderBy($sort_by, $sort_order)->paginate();
        }

        $data = [
            'event' => $event,
            'breakoutSessions' => $breakoutSessions,
            'sort_by'    => $sort_by,
            'sort_order' => $sort_order,
            'q'          => $searchQuery ? $searchQuery : '',
        ];
        return view('ManageEvent.BreakoutSessions', $data);
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreateBreakoutSession($event_id) {
        return view('ManageEvent.Modals.CreateBreakoutSession', [
            'event' => Event::scope()->find($event_id),
        ]);
    }

    /**
     * Create an breakout sessions
     *
     * @param Request $request
     * @param $event_id
     * @return mixed
     */
    public function postCreateBreakoutSession(Request $request, $event_id)
    {
        $breakoutSession = BreakoutSession::createNew();

        if(!$breakoutSession->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $breakoutSession->errors(),
            ]);
        }

        $start_date = Carbon::createFromFormat('Y-m-d H:i',
            $request->get('start_date'));
        $end_date = Carbon::createFromFormat('Y-m-d H:i',
            $request->get('end_date'));

        $breakoutSession->title = $request->get('title');
        $breakoutSession->description = $request->get('description');
        $breakoutSession->capacity = $request->get('capacity');
        $breakoutSession->event_id = $event_id;
        $breakoutSession->start_date = $start_date;
        $breakoutSession->end_date = $end_date;

        $breakoutSession->save();

        session()->flash('message', 'Successfully created breakout session.');

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => route('showBreakoutSessions', [
                'event_id' => $event_id,
            ]),
        ]);
    }

    /**
     * Downloads an export of breakout session
     *
     * @param $event_id
     * @param string $export_as (xlsx, xls, csv, html)
     */
    public function showExportBreakoutSession($event_id, $export_as = 'xls')
    {

        Excel::create('breakoutSessions-as-of-' . date('d-m-Y-g.i.a'), function ($excel) use ($event_id) {

            $excel->setTitle('breakoutSessions List');

            // Chain the setters
            $excel->setCreator(config('attendize.app_name'))
                ->setCompany(config('attendize.app_name'));

            $excel->sheet('breakoutSessions_sheet_1', function ($sheet) use ($event_id) {
                $event = Event::scope()->find($event_id);

                $data = $event->breakoutSessions()
                    ->select([
                        'title',
                        'description',
                        'capacity',
                        'number_of_subscribers',
                        'start_date',
                        'end_date',
                        'is_live',
                        'created_at',
                    ])->get();

                $sheet->fromArray($data);
                $sheet->row(1, [
                    'Title',
                    'Description',
                    'Capacity',
                    'Number_of_subscribers',
                    'Start_date',
                    'End_date',
                    'Is_live',
                    'Created_at',
                ]);

                // Set gray background on first row
                $sheet->row(1, function ($row) {
                    $row->setBackground('#f5f5f5');
                });
            });
        })->export($export_as);
    }

    /**
     * @param $event_id
     * @param $breakout_session_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditBreakoutSession($event_id, $breakout_session_id) {
        return view('ManageEvent.Modals.EditBreakoutSession', [
            'event' => Event::scope()->find($event_id),
            'breakoutSession' => BreakoutSession::find($breakout_session_id)
        ]);
    }

    /**
     * @param Request $request
     * @param $event_id
     * @param $breakout_session_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEditBreakoutSession(Request $request, $event_id, $breakout_session_id) {
        $breakoutSession = BreakoutSession::find($breakout_session_id);

        if(!$breakoutSession->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $breakoutSession->errors(),
            ]);
        }

        $start_date = Carbon::createFromFormat('Y-m-d H:i',
            $request->get('start_date'));
        $end_date = Carbon::createFromFormat('Y-m-d H:i',
            $request->get('end_date'));

        $breakoutSession->title = $request->get('title');
        $breakoutSession->description = $request->get('description');
        $breakoutSession->capacity = $request->get('capacity');
        $breakoutSession->event_id = $event_id;
        $breakoutSession->start_date = $start_date;
        $breakoutSession->end_date = $end_date;

        $breakoutSession->update();

        session()->flash('message', 'Successfully updated breakout session.');

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => route('showBreakoutSessions', [
                'event_id' => $event_id,
            ]),
        ]);
    }

    /**
     * @param $event_id
     * @param $breakout_session_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDeleteBreakoutSession($event_id, $breakout_session_id) {
        return view('ManageEvent.Modals.DeleteBreakoutSession', [
            'event' => Event::scope()->find($event_id),
            'breakoutSession' => BreakoutSession::find($breakout_session_id)
        ]);
    }

    /**
     * @param $event_id
     * @param $breakout_session_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteBreakoutSession($event_id, $breakout_session_id) {
        $breakoutSession = BreakoutSession::find($breakout_session_id);
        $breakoutSession->delete();

        session()->flash('message', 'Successfully deleted breakout session.');

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => route('showBreakoutSessions', [
                'event_id' => $event_id,
            ]),
        ]);
    }
}
