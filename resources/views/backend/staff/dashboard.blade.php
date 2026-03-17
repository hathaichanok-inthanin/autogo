@extends('backend/layouts/template-staff')

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <p>ยอดขายวันนี้</p>
                            <h3>{{ number_format($totalSalesToday, 2) }} บาท</h3>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512">
                            <path
                                d="M320 0C214 0 128 35.8 128 80v52.6C53.5 143.6 0 173.2 0 208v224c0 44.2 86 80 192 80s192-35.8 192-80v-52.7c74.5-11 128-40.5 128-75.3V80c0-44.2-86-80-192-80zm16 428.3C326 440 275.6 464 192 464S58 440 48 428.3v-39.5c35.2 16.6 86.6 27.2 144 27.2s108.8-10.6 144-27.2v39.5zm0-96C326 344 275.6 368 192 368S58 344 48 332.3v-44.9c35.2 20 86.6 32.6 144 32.6s108.8-12.7 144-32.6v44.9zM192 272c-79.5 0-144-21.5-144-48s64.5-48 144-48 144 21.5 144 48-64.5 48-144 48zm272 28.3c-7.1 8.3-34.9 22.6-80 30.4V283c31-4.6 58.7-12.1 80-22.2v39.5zm0-96c-7.1 8.3-34.9 22.6-80 30.4V208c0-7.2-2.5-14.2-6.8-20.9 33.8-5.3 64-14.8 86.8-27.8v45zM320 144c-5 0-9.8-.3-14.7-.5-26-7.9-56.8-13.2-90.4-14.9C191 120 176 108.6 176 96c0-26.5 64.5-48 144-48s144 21.5 144 48-64.5 48-144 48z" />
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <p>รอชำระเงิน</p>
                            <h3>{{ $pendingPaymentCount }} รายการ</h3>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512">
                            <path
                                d="M461.2 128H80c-8.84 0-16-7.16-16-16s7.16-16 16-16h384c8.84 0 16-7.16 16-16 0-26.51-21.49-48-48-48H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h397.2c28.02 0 50.8-21.53 50.8-48V176c0-26.47-22.78-48-50.8-48zM416 336c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32z" />
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <p>คำสั่งซื้อรอติดตั้ง</p>
                            <h3>{{ $pendingShippingCount }} รายการ</h3>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 640 512">
                            <path
                                d="M425.7 256c-16.9 0-32.8-9-41.4-23.4L320 126l-64.2 106.6c-8.7 14.5-24.6 23.5-41.5 23.5-4.5 0-9-.6-13.3-1.9L64 215v178c0 14.7 10 27.5 24.2 31l216.2 54.1c10.2 2.5 20.9 2.5 31 0L551.8 424c14.2-3.6 24.2-16.4 24.2-31V215l-137 39.1c-4.3 1.3-8.8 1.9-13.3 1.9zm212.6-112.2L586.8 41c-3.1-6.2-9.8-9.8-16.7-8.9L320 64l91.7 152.1c3.8 6.3 11.4 9.3 18.5 7.3l197.9-56.5c9.9-2.9 14.7-13.9 10.2-23.1zM53.2 41L1.7 143.8c-4.6 9.2.3 20.2 10.1 23l197.9 56.5c7.1 2 14.7-1 18.5-7.3L320 64 69.8 32.1c-6.9-.8-13.5 2.7-16.6 8.9z" />
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <p>คิวติดตั้งวันนี้</p>
                            <h3>{{ $appointmentsCount }} คัน</h3>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 640 512">
                            <path
                                d="M544 192h-16L419.22 56.02A64.025 64.025 0 0 0 369.24 32H155.33c-26.17 0-49.7 15.93-59.42 40.23L48 194.26C20.44 201.4 0 226.21 0 256v112c0 8.84 7.16 16 16 16h48c0 53.02 42.98 96 96 96s96-42.98 96-96h128c0 53.02 42.98 96 96 96s96-42.98 96-96h48c8.84 0 16-7.16 16-16v-80c0-53.02-42.98-96-96-96zM160 432c-26.47 0-48-21.53-48-48s21.53-48 48-48 48 21.53 48 48-21.53 48-48 48zm72-240H116.93l38.4-96H232v96zm48 0V96h89.24l76.8 96H280zm200 240c-26.47 0-48-21.53-48-48s21.53-48 48-48 48 21.53 48 48-21.53 48-48 48z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-warning card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">รายการสั่งซื้อวันนี้</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ลูกค้า / รถยนต์</th>
                                        <th>รายการสินค้า</th>
                                        <th>ยอดชำระ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($todayOrders as $todayOrder)
                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-bold">{{ $todayOrder->name }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            {{ $todayOrder->tel }}
                                                        </div>

                                                        @if (!empty($todayOrder->license_plate))
                                                            <span class="license-plate-badge">{{ $todayOrder->car_detail }}
                                                                {{ $todayOrder->license_plate }}</span>
                                                        @elseif (!empty($todayOrder->car_detail))
                                                            <span
                                                                class="license-plate-badge">{{ $todayOrder->car_detail }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                @if ($todayOrder->orderDetails->count() > 0)
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <div class="text-dark small fw-bold">
                                                                {{ $todayOrder->orderDetails->first()->product_name }}
                                                            </div>
                                                            @if ($todayOrder->orderDetails->count() > 1)
                                                                <div class="text-muted" style="font-size: 14px;">
                                                                    และอีก {{ $todayOrder->orderDetails->count() - 1 }}
                                                                    รายการ
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">- ไม่มีข้อมูลสินค้า -</span>
                                                @endif
                                            </td>

                                            <td>
                                                <h6 class="mb-0 fw-bold">{{ number_format($todayOrder->total_price, 0) }}
                                                    บาท
                                                </h6>

                                                @if ($todayOrder->payment_status == 'paid')
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success border border-success px-2 mt-1">
                                                        จ่ายแล้ว
                                                    </span>
                                                @elseif($todayOrder->payment_status == 'pending')
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger border border-danger px-2 mt-1">
                                                        รอชำระเงิน
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="text-muted opacity-50 mb-2">
                                                    <i class="fa-solid fa-clipboard-list fa-3x"></i>
                                                </div>
                                                <p class="text-muted">ไม่พบรายการในสถานะนี้</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-danger card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">ตารางนัดหมายวันนี้</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>เวลา</th>
                                        <th>สาขา</th>
                                        <th>ข้อมูลรถ</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todayAppointments as $todayAppointment)
                                        <tr>
                                            <td>{{ $todayAppointment->booking_time }}</td>
                                            <td>{{ $todayAppointment->shop->shop_name }}
                                                {{ $todayAppointment->shop->branch_name }}</td>
                                            <td>{{ $todayAppointment->car_detail }} {{ $todayAppointment->license_plate }}
                                            </td>
                                            <td>
                                                @if ($todayAppointment->status == 'pending')
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger border border-danger px-2 mt-1">
                                                        รอติดตั้ง
                                                    </span>
                                                @elseif($todayAppointment->status == 'completed')
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success border border-success px-2 mt-1">
                                                        เสร็จสิ้น
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
