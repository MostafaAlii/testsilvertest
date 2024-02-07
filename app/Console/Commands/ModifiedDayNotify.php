<?php

namespace App\Console\Commands;

use App\Models\OrderDay;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\UserSaveRend;

class ModifiedDayNotify extends Command
{
    protected $signature = 'app:modified-day-notify';
    protected $description = 'Order Day Send Notify Before 20 minutes';
    public function handle()
    {
        // Get All Orders Days ::
        $order_days = DB::table('order_days')->where('status', 'accepted')
            ->where('end_day', Carbon::now()->format('Y-m-d'))
            ->select('id', 'user_id', 'captain_id', 'order_code', 'start_day', 'end_day', 'number_day', 'start_time')
            ->get();
        foreach ($order_days as $order_day) {
            $orders = OrderDay::findorfail($order_day->id);
            $check = DB::table('user_save_rends')->where('order_day_id', $order_day->id)->where('user_id', $order_day->user_id)->first();
            $startTime = Carbon::parse($order_day->start_time);
            $modifiedStartTime = $startTime->subMinutes(20)->format('h:i A');
            if ($order_day->end_day == date('Y-m-d') && $modifiedStartTime == now()->format('h:i A')) {
                if (!$check) {
                    sendNotificationUser($order_day->user_id, 'هل ترغب تمديد المده ', 'تمديد الرحله', true);
                    sendNotationsFirebaseDay($order_day->id);
                    $this->info('Created User Notification Successfully and Push firebase');
                    UserSaveRend::create([
                        'order_day_id' => $order_day->id,
                        'user_id' => $order_day->user_id,
                        'notify_status' => true
                    ]);


                    $orders->update([
                        "type_duration" => "active",
                    ]);
                }
                $this->info('Created UserSaveRend Successfully');
                echo "Order ID: " . $order_day->id . " - Modified Day: " . $order_day->end_day . ' _ ' . $modifiedStartTime  . PHP_EOL;
            }
        }
    }
}
