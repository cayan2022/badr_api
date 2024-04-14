<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\SubStatus;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;

class SubStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status2 = Status::find(2);
        $status2->subStatuses()->createMany([
            [
                'status_id' => 2,
                'ar' => ['name' => 'في انتظار الدفع'],
                'en' => ['name' => 'Wait to Pay']
            ],
            [
                'status_id' => 2,
                'ar' => ['name' => 'تأجيل التواصل'],
                'en' => ['name' => 'Delay Contact']
            ],
            [
                'status_id' => 2,
                'ar' => ['name' => 'غير متاح'],
                'en' => ['name' => 'Unavailable']
            ],
        ]);

        $status3 = Status::find(3);
        $status3->subStatuses()->createMany([
            [
                'status_id' => 3,
                'ar' => ['name' => 'تم الدفع'],
                'en' => ['name' => 'Paid']
            ]
        ]);


        $status4 = Status::find(4);
        $status4->subStatuses()->createMany([
            [
                'status_id' => 4,
                'ar' => ['name' => 'سيقرر لاحقا'],
                'en' => ['name' => 'will decide later']
            ],
            [
                'status_id' => 4,
                'ar' => ['name' => 'غير جاد'],
                'en' => ['name' => 'not serious']
            ],
            [
                'status_id' => 4,
                'ar' => ['name' => 'استفسار فقط'],
                'en' => ['name' => 'Inquiry only']
            ],
            [
                'status_id' => 4,
                'ar' => ['name' => 'خدمة غير موجودة'],
                'en' => ['name' => 'Service does not exist']
            ],
            [
                'status_id' => 4,
                'ar' => ['name' => 'عروض غير مناسبة'],
                'en' => ['name' => 'Service does not exist']
            ],
            [
                'status_id' => 4,
                'ar' => ['name' => 'لايوجد رد'],
                'en' => ['name' => 'no answer']
            ]
        ]);
    }
}
