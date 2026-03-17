<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Carbon::macro('thaidate', function ($format = 'j M Y') {
            // เก็บชื่อเดือนภาษาไทย
            $thai_months = [
                1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.', 5 => 'พ.ค.', 6 => 'มิ.ย.',
                7 => 'ก.ค.', 8 => 'ส.ค.', 9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
            ];
            
            // ดึงข้อมูลวันที่ปัจจุบัน
            $date = $this;
            
            // เปลี่ยนปี ค.ศ. เป็น พ.ศ.
            $year = $date->year + 543;
            
            // เปลี่ยนเดือนเป็นภาษาไทย
            $month = $thai_months[$date->month];
            
            // แทนค่าลงใน Format
            return str_replace(
                ['j', 'M', 'Y'], 
                [$date->day, $month, $year], 
                $format
            );
        });

        Paginator::defaultView('custom-pagination');
        Paginator::defaultSimpleView('custom-pagination');
    }
}
