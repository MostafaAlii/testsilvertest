<?php

namespace App\Console\Commands;

use App\Models\SaveRentDay;
use App\Models\UserSaveRend;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckOrderDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-order-day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ordersSaveDays = SaveRentDay::get();
        if ($ordersSaveDays->count() > 0) {
            foreach ($ordersSaveDays as $ordersSaveDay) {
                $orders = SaveRentDay::findorfail($ordersSaveDay->id);
                $check = UserSaveRend::where('user_id',$orders->user_id)->where('save_rent_day_id',$orders->id)->first();
                if ($ordersSaveDay->status == 'cancel') {
                    $ordersSaveDay->delete();
                    $this->comment('Deleted Orders status cancel');
                }


                if ($ordersSaveDay->start_day == Carbon::now()->format('Y-m-d')) {

                    $timeDifferenceInMinutes = Carbon::now()->diffInMinutes($ordersSaveDay->start_time);

                    if ($timeDifferenceInMinutes == 20) {
                        if(!$check){
                            UserSaveRend::create(['user_id' => $orders->user_id, 'save_rent_day_id' => $orders->id]);
                            sendNotificationUserCheck($ordersSaveDay->user_id, 'من فضلك قم بتأكيد الرحله', 'تأكيد الرحله',$orders->order_code ,true);

                        }
                        $orders->update([
                            'status' => "accepted"
                        ]);
                    }

                    if ($timeDifferenceInMinutes == 10) {
                        if(!$check){
                            UserSaveRend::create(['user_id' => $orders->user_id, 'save_rent_day_id' => $orders->id]);
                            sendNotificationUserCheck($ordersSaveDay->user_id, 'من فضلك قم بتأكيد الرحله', 'تأكيد الرحله',$orders->order_code ,true);
                        }
                        $orders->update([
                            'status' => "accepted"
                        ]);;
                    }
                    if ($timeDifferenceInMinutes == 5) {
                        if(!$check){
                            UserSaveRend::create(['user_id' => $orders->user_id, 'save_rent_day_id' => $orders->id]);
                            sendNotificationUserCheck($ordersSaveDay->user_id, 'من فضلك قم بتأكيد الرحله', 'تأكيد الرحله',$orders->order_code ,true);
                        }
                        $orders->update([
                            'status' => "accepted"
                        ]);
                    }

                    if ($timeDifferenceInMinutes == 1) {
                        if(!$check){
                            UserSaveRend::create(['user_id' => $orders->user_id, 'save_rent_day_id' => $orders->id]);
                            sendNotificationUserCheck($ordersSaveDay->user_id, 'من فضلك قم بتأكيد الرحله', 'تأكيد الرحله',$orders->order_code ,true);
                        }
                        $orders->update([
                            'status' => "accepted"
                        ]);
                    }

                    $this->comment('Orders Send ' . $timeDifferenceInMinutes);
                }



                // Check Time Out

                $dataCheck = $ordersSaveDay->start_day . $ordersSaveDay->start_time;
                $dataCheckTimeOut = Carbon::parse($dataCheck)->addMinutes(20)->format('Y-m-d g:i A');
                $dataNowCheckTimeOut =Carbon::now()->format('Y-m-d g:i A');

                if ($dataCheckTimeOut == $dataNowCheckTimeOut){
                    sendNotificationUser($ordersSaveDay->user_id, 'لقد تم الغاء الرحله لعدم التأكيد', 'الغاء الرحله', true);
                    $ordersSaveDay->delete();
                }




                //Check Orders Sub Dayes

                $dataCheck = $ordersSaveDay->start_day;

                $dataSub = Carbon::now()->subDay()->format('Y-m-d');
                $checks = $dataCheck == $dataSub;
                if ($checks == true){
                    sendNotificationUser($ordersSaveDay->user_id, 'لقد تم الغاء الرحله لعدم التأكيد', 'الغاء الرحله', true);
                    $ordersSaveDay->delete();
                }

            }
        }
    }
}
