<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\PromoCode;
use App\Http\Requests;
use Excel;

class EventPromoCodesController extends MyBaseController
{
    /**
     * Show the promoCodes list
     *
     * @param Request $request
     * @param $event_id
     * @return View
     */
    public function showPromoCodes(Request $request, $event_id = '')
    {
        $allowed_sorts = ['code', 'discount_type', 'number_of_uses',
            'start_date', 'end_date','is_paused', 'created_at',];

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

            $promoCodes = $event->promoCodes()
                ->where(function ($query) use ($searchQuery) {
                    $query->where('code', 'like', $searchQuery . '%');
                })
                ->orderBy($sort_by, $sort_order)
                ->paginate();
        } else {
            $promoCodes = $event->promoCodes()->orderBy($sort_by, $sort_order)->paginate();
        }

        $data = [
            'event' => $event,
            'promoCodes' => $promoCodes,
            'sort_by'    => $sort_by,
            'sort_order' => $sort_order,
            'q'          => $searchQuery ? $searchQuery : '',
        ];

        return view('ManageEvent.PromoCodes', $data);
    }

    /**
     * Show the create promo code modal
     *
     * @param $event_id
     * @return \Illuminate\Contracts\View\View
     */
    public function showCreatePromoCode($event_id)
    {
        return view('ManageEvent.Modals.CreatePromoCode', [
            'event' => Event::scope()->find($event_id),
        ]);
    }

    /**
     * Create an promocode
     *
     * @param Request $request
     * @param $event_id
     * @return mixed
     */
    public function postCreatePromoCode(Request $request, $event_id)
    {
        $promoCode = PromoCode::where('code', $request->get('code'))->first();
        if($promoCode) {
            return response()->json([
                'status'   => 'error',
                'messages' => [
                    'code' => 'Already exists.'
                ],
            ]);
        }

        $promoCode = PromoCode::createNew();

        if(!$promoCode->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $promoCode->errors(),
            ]);
        }

        $discount_type = $request->get('discount_type');
        $discount = $request->get('discount');

        if($discount_type === "0") {
            if($discount < 0 || $discount > 100) {
                return response()->json([
                    'status'   => 'error',
                    'messages' => [
                        'discount' => 'Must be between  0 to 100.'
                    ],
                ]);
            }
        }

        $promoCode->code = $request->get('code');
        $promoCode->description = $request->get('description');
        $promoCode->event_id = $event_id;
        $promoCode->discount_type = $discount_type;
        $promoCode->discount = $discount;
        $promoCode->max_redemption = $request->get('max_redemption');
        $promoCode->start_date = $request->get('start_date') ? Carbon::createFromFormat('d-m-Y H:i',
            $request->get('start_date')) : null;
        $promoCode->end_date = $request->get('end_date') ? Carbon::createFromFormat('d-m-Y H:i',
            $request->get('end_date')) : null;

        $promoCode->save();

        session()->flash('message', 'Successfully created Promo code');

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => route('showPromoCodes', [
                'event_id' => $event_id,
            ]),
        ]);
    }

    /**
     * Downloads an export of attendees
     *
     * @param $event_id
     * @param string $export_as (xlsx, xls, csv, html)
     */
    public function showExportPromoCodes($event_id, $export_as = 'xls')
    {

        Excel::create('promoCodes-as-of-' . date('d-m-Y-g.i.a'), function ($excel) use ($event_id) {

            $excel->setTitle('promoCodes List');

            // Chain the setters
            $excel->setCreator(config('attendize.app_name'))
                ->setCompany(config('attendize.app_name'));

            $excel->sheet('promoCodes_sheet_1', function ($sheet) use ($event_id) {
                $event = Event::scope()->find($event_id);

                $data = $event->promoCodes()
                    ->select([
                        'code',
                        'description',
                        'discount_type',
                        'number_of_uses',
                        'start_date',
                        'end_date',
                        'is_paused',
                        'created_at',
                    ])->get();

                $sheet->fromArray($data);
                $sheet->row(1, [
                    'Code',
                    'Description',
                    'Discount_type',
                    'Number_of_uses',
                    'Start_date',
                    'End_date',
                    'Is_paused',
                    'Created_at',
                ]);

                // Set gray background on first row
                $sheet->row(1, function ($row) {
                    $row->setBackground('#f5f5f5');
                });
            });
        })->export($export_as);
    }
}
