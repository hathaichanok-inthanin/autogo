@extends('backend/layouts/template-staff')

@section('content')
    <div class="container-fluid mt-4 pb-5">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="fa-solid fa-calendar-check me-2 text-warning"></i>รายการสั่งซื้อทั้งหมด
                </h4>
            </div>

            <form action="{{ route('orders.index') }}" method="GET" class="d-flex gap-2" style="min-width: 350px;">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control border-start-0"
                        placeholder="ค้นหาทะเบียนรถ, เบอร์โทร, ชื่อ..." value="{{ request('search') }}">
                    <button class="btn btn-dark" type="submit">ค้นหา</button>
                </div>
            </form>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-5">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th>Order / วันที่ทำรายการ</th>
                            <th>ลูกค้า / รถยนต์</th>
                            <th>รายการสินค้า</th>
                            <th>สาขา / เวลานัดหมาย</th>
                            <th>ยอดชำระ</th>
                            <th>สถานะงาน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">#{{ $order->order_number }}</div>
                                    <small class="text-muted">
                                        <i
                                            class="fa-regular fa-clock me-1"></i>{{ $order->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-bold">{{ $order->name }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ $order->tel }}
                                            </div>

                                            @if (!empty($order->license_plate))
                                                <span class="license-plate-badge">{{ $order->car_detail }}
                                                    {{ $order->license_plate }}</span>
                                            @elseif (!empty($order->car_detail))
                                                <span class="license-plate-badge">{{ $order->car_detail }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @if($order->orderDetails->count() > 0)
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="text-dark small fw-bold">
                                                    {{ $order->orderDetails->first()->product_name }}
                                                    (x{{ $order->orderDetails->first()->quantity }})
                                                </div>
                                                @if($order->orderDetails->count() > 1)
                                                    <div class="text-muted" style="font-size: 14px;">
                                                        และอีก {{ $order->orderDetails->count() - 1 }} รายการ
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">- ไม่มีข้อมูลสินค้า -</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="fw-bold text-dark">
                                        <i class="fa-solid fa-store me-1 text-primary"></i>
                                        {{ $order->shop->shop_name }} {{ $order->shop->branch_name }}
                                    </div>

                                    <div class="mt-1 text-danger fw-bold small">
                                        <i class="fa-regular fa-calendar-check me-1"></i>
                                        นัดหมาย :
                                        {{ \Carbon\Carbon::parse($order->booking_date)->format('d/m/Y') }}
                                        {{ $order->booking_time ? ' เวลา ' . $order->booking_time : '' }}
                                    </div>
                                </td>

                                <td>
                                    <h6 class="mb-0 fw-bold">{{ number_format($order->total_price, 0) }} บาท</h6>

                                    @if ($order->payment_status == 'paid')
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success px-2 mt-1">
                                            <i class="fa-solid fa-check-circle"></i> จ่ายแล้ว
                                        </span>
                                        @if ($order->payment_ref_id)
                                            <div class="text-muted" style="font-size: 10px;">Auto :
                                                {{ Str::limit($order->payment_ref_id, 8) }}</div>
                                        @endif
                                    @endif
                                </td>

                                <td>
                                    @php
                                        $statusClass = 'secondary';
                                        $statusText = $order->status;

                                        if ($order->status == 'completed') {
                                            $statusClass = 'success';
                                            $statusText = 'เสร็จสิ้น';
                                        } elseif ($order->status == 'cancelled') {
                                            $statusClass = 'danger';
                                            $statusText = 'ยกเลิก';
                                        } elseif (
                                            $order->status == 'confirmed' ||
                                            ($order->payment_status == 'paid' && $order->status != 'completed')
                                        ) {
                                            $statusClass = 'info text-dark';
                                            $statusText = 'รอติดตั้ง';
                                        } elseif ($order->status == 'pending') {
                                            $statusText = 'รอยืนยัน';
                                        }
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
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
@endsection
