<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

class CleanUpOldData extends Command
{
    protected $signature = 'data:cleanup';

    protected $description = 'ลบข้อมูลออเดอร์ที่มีอายุเกิน 1 วันอัตโนมัติ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $threshold = now()->subDay();

        $oldParentIds = \App\Models\Order::where('payment_status','pending')->where('created_at', '<', $threshold)->pluck('id');

        if ($oldParentIds->isNotEmpty()) {

        \App\Models\OrderDetail::whereIn('order_id', $oldParentIds)->delete();

        $count = \App\Models\Order::whereIn('id', $oldParentIds)->delete();

        $this->info("ลบข้อมูลสำเร็จ: $count รายการ");
        } else {
            $this->info("ไม่มีข้อมูลเก่าที่ต้องลบ");
        }
    }
}
