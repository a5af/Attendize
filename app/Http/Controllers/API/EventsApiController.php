<?php

namespace app\Http\Controllers\API;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Organiser;
use App\Models\Account;
use App\Models\User;
use Validator;
use Log;
use Carbon\Carbon;

class EventsApiController extends ApiBaseController
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return Event::scope($this->account_id)->paginate(20);
    }

    /**
     * @param Request $request
     * @param $attendee_id
     * @return mixed
     */
    public function show(Request $request, $attendee_id)
    {
        if ($attendee_id) {
            return Event::scope($this->account_id)->find($attendee_id);
        }

        return response('Event Not Found', 404);
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        $rules = [
        'title'               => ['required'],
        'description'         => ['required'],
        'location_venue_name' => ['required_without:venue_name_full'],
        'venue_name_full'     => ['required_without:location_venue_name'],
        'start_date'          => ['required'],
        'end_date'            => ['required'],
        ];

        $messages = [
        'title.required'                       => 'You must at least give a title for your event.',
        'location_venue_name.required_without' => 'Please enter a venue for your event',
        'venue_name_full.required_without'     => 'Please enter a venue for your event',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        try {
            $event = Event::where('title', $data['title'])->first();
            if(!$event) {
                $user = User::take(1)->get();
                $event = Event::createNew($this->account_id, $user[0]->id);

                $event->title = $data['title'];
                $event->description = strip_tags($data['description']);
                $event->start_date = $data['start_date'] ? Carbon::createFromFormat('d-m-Y H:i',
                    $data['start_date']) : null;
                $event->end_date = $data['end_date'] ? Carbon::createFromFormat('d-m-Y H:i',
                    $data['end_date']) : null;


                /*
                 * Venue location info
                 */
                $event->venue_name = $data['location_venue_name'];
                $event->location_address_line_1 = $data['location_address_line_1'];
                $event->location_address_line_2 = $data['location_address_line_2'];
                $event->location_state = $data['location_state'];
                $event->location_post_code = $data['location_post_code'];
                $event->location_is_manual = 1;

                $account = Account::take(1)->get();

                $event->currency_id = $account[0]->currency_id;

                /*
                 * Set a default background for the event
                 */
                $event->bg_type = 'image';
                $event->bg_image_path = config('attendize.event_default_bg_image');

                $organiser = Organiser::take(1)->get();
                $event->organiser_id = $organiser[0]->id;


                /*
                 * Set the event defaults.
                 * @todo these could do mass assigned
                 */
                $defaults = $event->organiser->event_defaults;
                if ($defaults) {
                    $event->organiser_fee_fixed = $defaults->organiser_fee_fixed;
                    $event->organiser_fee_percentage = $defaults->organiser_fee_percentage;
                    $event->pre_order_display_message = $defaults->pre_order_display_message;
                    $event->post_order_display_message = $defaults->post_order_display_message;
                    $event->offline_payment_instructions = $defaults->offline_payment_instructions;
                    $event->enable_offline_payments = $defaults->enable_offline_payments;
                    $event->social_show_facebook = $defaults->social_show_facebook;
                    $event->social_show_linkedin = $defaults->social_show_linkedin;
                    $event->social_show_twitter = $defaults->social_show_twitter;
                    $event->social_show_email = $defaults->social_show_email;
                    $event->social_show_googleplus = $defaults->social_show_googleplus;
                    $event->social_show_whatsapp = $defaults->social_show_whatsapp;
                    $event->is_1d_barcode_enabled = $defaults->is_1d_barcode_enabled;
                    $event->ticket_border_color = $defaults->ticket_border_color;
                    $event->ticket_bg_color = $defaults->ticket_bg_color;
                    $event->ticket_text_color = $defaults->ticket_text_color;
                    $event->ticket_sub_text_color = $defaults->ticket_sub_text_color;
                }


                $event->save();
            }
        }catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'messages' => 'Whoops! There was a problem creating your event. Please try again.',
            ]);
        }

        return response()->json([
            'status'      => 'success',
            'id'          => $event->id,
        ]);
    }

    public function update(Request $request)
    {
    }

    public function destroy(Request $request)
    {
    }

}