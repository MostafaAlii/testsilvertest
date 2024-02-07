<?php

namespace App\Console\Commands;

use App\Models\OrderHour;
use App\Models\UserSaveRend;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModifiedHourNotify extends Command
{
    protected $signature = 'app:modified-hour-notify';
    protected $description = 'Order Hour Send Notify Before 15 minutes';
    public function handle()
    {
        // Get All Orders Hour ::
        $order_hours = DB::table('order_hours')
            ->where('status', 'accepted')
            ->where('data', Carbon::now()->format('Y-m-d'))
            ->join('hours', 'order_hours.hour_id', '=', 'hours.id')
            ->select(
                'order_hours.id',
                'order_hours.user_id',
                'order_hours.captain_id',
                DB::raw('CAST(order_hours.hours_from AS DECIMAL(10, 2)) + CAST(hours.number_hours AS DECIMAL(10, 2)) as total_hours'),
                'order_hours.hours_from',
                'order_hours.hour_id',
                'hours.price_hours',
                'hours.number_hours'
            ) ->get();
        foreach ($order_hours as $order_hour) {
            $check = DB::table('user_save_rends')->where('order_hour_id', $order_hour->id)->where('user_id', $order_hour->user_id)->first();

            $timeCut = str_replace('pm', '', $order_hour->hours_from);
            $orderTime = Carbon::parse($timeCut);
            $totalHours = $orderTime->addHours($order_hour->number_hours)->subMinutes(15)->format('h:i');
//            dd($totalHours);
            $checkTime = $totalHours == Carbon::now()->format('h:i');
            if ($checkTime) {
                if (!$check) {
                    UserSaveRend::create([
                        'order_hour_id' => $order_hour->id,
                        'user_id' => $order_hour->user_id,
                        'notify_status' => true
                    ]);
                    $this->info('Created UserSaveRend Successfully');
                    $order_hour_model = OrderHour::find($order_hour->id);
                    $order_hour_model->update([
                        "type_duration" => 'active',
                    ]);

                    $this->info('Update OrderHour Status Successfuly');
                    sendNotificationUser($order_hour->user_id, 'هل ترغب تمديد المده ', 'تمديد الرحله', true);
                    sendNotationsFirebase($order_hour->id);
                    echo "UserId: " . "Order ID: " . $order_hour->id . " - Modified Hour: " . $totalHours . PHP_EOL;
                }
            }
        }
    }
}
