<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Timezone;
use App\Models\User;
use App\Models\Role;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Event;
use App\Models\EventStats;
use App\Models\Attendee;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use PhpSpec\Exception\Exception;

class CRMMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendize:crm_migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate CRM event data';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            DB::connection();
        } catch (\Exception $e) {
            $this->error('Unable to connect to database.');
            $this->error('Please fill valid database credentials into .env and rerun this command.');
            return;
        }

        $this->comment('--------------------');
        $this->comment('Attempting to migrate CRM event data');
        $this->comment('--------------------');

        $this->comment('Migrating users');

        $account = Account::take(1)->get();
        $account_id = $account[0]->id;
        try {
            DB::beginTransaction();
            $content = file_get_contents(base_path('crm_migration/users.json'));
            $users = json_decode($content, true);
            $unmigrated_users = [];
            foreach ($users as $data) {
                $user = User::where('email', $data['email'])->first();
                if (!$user) {
                    if ($data['isadmin'] == '1') {
                        $role = 'admin';
                    } else if ($data['isagent'] == '1') {
                        $role = 'agent';
                    } else {
                        array_push($unmigrated_users, $data);
                        continue;
                    }

                    $userRole = Role::where('name', $role)->first();
                    $user = new User();
                    $user->email = $data['email'];
                    $user->agentcode = $data['agentcode'];
                    $user->first_name = $data['firstname'];
                    $user->last_name = $data['lastname'];
                    $user->password = $data['password'];
                    $user->phone = $data['phone'];
                    $user->account_id = $account_id;
                    $user->save();
                    $user->attachRole($userRole);
                }
            }

            if(count($unmigrated_users) > 0) {
                $this->comment('There are some unmigrated users. Check this file: '
                    . base_path('crm_migration/unmigrated_users.json'));
                file_put_contents(base_path('crm_migration/unmigrated_users.json'), json_encode($unmigrated_users));
            }

            $this->comment('User migration succeed.');

            $this->comment('--------------------');

            DB::commit();
        } catch (\Exception $e) {
            $this->error($e);
            DB::rollBack();
            return;
        }

        $this->comment('Migrating orders and tickets');

        try {
            $content = file_get_contents(base_path('crm_migration/crm_98_event.json'));
            $orders = json_decode($content, true);
            $event = Event::where('title', '=', '2018 National Winter Convention')->first();
            if(!$event) {
                $this->error('Can not find "2018 National Winter Convention" event.');
                return;
            }

            $ticket = $event->tickets()->where('title', '=', 'GEN')->first();
            if(!$ticket) {
                $this->error('Can not find GEN ticket.');
                return;
            }

            DB::beginTransaction();
            $unmigrated_tickets = [];

            foreach($orders as $data) {
                $user = User::where('email', '=', $data['email'])->first();
                if(!$user) {
                    array_push($unmigrated_tickets, $data);
                    continue;
                }

                $order = new Order();
                $order->payment_gateway_id = 2;
                $order->first_name = $user->first_name;
                $order->last_name = $user->last_name;
                $order->email = $data['email'];
                $order->order_status_id = 1;
                $order->amount = $data['paymentamount'];
                $order->booking_fee = 0;
                $order->organiser_booking_fee = 0;
                $order->discount = 0;
                $order->account_id = $account_id;
                $order->event_id = $event->id;
                $order->is_payment_received = 1;
                $order->created_at = $data['created_at'];

                $order->save();

                /*
                    * Update the event sales volume
                */
                $event->increment('sales_volume', $order->amount);

                /*
                    * Update the event stats
                */

                $event_stats = EventStats::firstOrNew([
                    'event_id' => $event->id,
                    'date'     => DB::raw('CURRENT_DATE'),
                ]);

                $event_stats->increment('tickets_sold', $data['noofseats']);
                $event_stats->increment('sales_volume', $order->amount);

                $event_stats->save();


                /*
                 * Insert order items (for use in generating invoices)
                 */
                $orderItem = new OrderItem();
                $orderItem->title = $ticket->title;
                $orderItem->quantity = $data['noofseats'];
                $orderItem->order_id = $order->id;
                $orderItem->unit_price = $data['paymentamount'] / $data['noofseats'];
                $orderItem->save();

                /*
                 * Update ticket info
                 */

                $ticket->increment('quantity_sold', $data['noofseats']);

                $ticket->increment('sales_volume', $data['paymentamount']);


                /*
                    * Add the attendees
                */

                $attendee_increment = 1;
                foreach($data['tickets'] as $t) {
                    $attendee = new Attendee();
                    $attendee->first_name = $user->first_name;
                    $attendee->last_name = $user->last_name;
                    $attendee->email = $data['email'];
                    $attendee->event_id = $event->id;
                    $attendee->order_id = $order->id;
                    $attendee->ticket_id = $ticket->id;
                    $attendee->account_id = $account_id;
                    $attendee->reference_index = $attendee_increment;
                    $attendee->purchased_by = $user->id;
                    $attendee->assigned_to = $t['assigned_to'];
                    $attendee->save();
                    $attendee_increment++;
                }

            }

            if(count($unmigrated_tickets) > 0) {
                $this->comment('There are some unmigrated tickets. Check this file: '
                    . base_path('crm_migration/unmigrated_tickets.json'));
                file_put_contents(base_path('crm_migration/unmigrated_tickets.json'), json_encode($unmigrated_tickets));
            }
            DB::commit();
        } catch (\Exception $e) {
            $this->error($e);
            DB::rollBack();
            return;
        }

        $this->comment('Success!');
    }
}
