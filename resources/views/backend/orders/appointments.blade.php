@extends('backend/layouts/template')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 text-dark mb-0">
                <i class="fas fa-calendar-alt me-2 text-primary"></i>ตารางนัดหมายติดตั้ง
            </h2>
        </div>

        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <form action="{{ route('appointments.index') }}" method="GET" id="filterForm">
                    <div class="row g-3">

                        <div class="col-md-3">
                            <label class="form-label text-muted small">สาขา</label>
                            <select name="branch_id" class="form-select" onchange="this.form.submit()">
                                <option value="all">ทุกสาขา</option>
                                @foreach ($shops as $shop)
                                    <option value="{{ $shop->id }}"
                                        {{ request('branch_id') == $shop->id ? 'selected' : '' }}>
                                        {{ $shop->shop_name }} {{ $shop->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-muted small">วันที่</label>
                            <input type="date" name="date" class="form-control" value="{{ request('date') }}"
                                onchange="this.form.submit()">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted small">ค้นหาทั่วไป</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"></span>
                                <input type="text" name="search" class="form-control border-start-0 ps-0"
                                    placeholder="ทะเบียนรถ, เบอร์โทร..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-dark w-100">
                                <i class="fas fa-filter me-1"></i> กรองข้อมูล
                            </button>
                            <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">ล้าง</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small uppercase">
                            <tr>
                                <th>วัน/เวลานัด</th>
                                <th class="py-3">ข้อมูลรถ</th>
                                <th class="py-3">ข้อมูลลูกค้า</th>
                                <th class="py-3">รายการบริการ</th>
                                <th class="py-3">สาขาที่ติดตั้ง</th>
                                <th class="py-3 text-end pe-4">ยืนยันสถานะการติดตั้ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <small class="fw-bold text-dark">
                                            {{ $order->booking_date }}
                                        </small>
                                        <div class="small text-muted">เวลา {{ $order->booking_time }} น.</div>
                                    </td>

                                    <td>
                                        <div class="fw-bold text-dark">{{ $order->license_plate }}</div>
                                        <div class="small text-muted">{{ $order->car_detail }}</div>
                                    </td>

                                    <td>
                                        <div class="fw-bold">{{ $order->name }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ $order->tel }}
                                        </div>
                                    </td>

                                    <td>
                                        @if ($order->orderDetails->count() > 0)
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="text-dark small fw-bold">
                                                        {{ $order->orderDetails->first()->product_name }}
                                                        (x{{ $order->orderDetails->first()->quantity }})
                                                    </div>
                                                    @if ($order->orderDetails->count() > 1)
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
                                        <span class="badge bg-light text-dark border">
                                            {{ $order->shop->shop_name }} {{ $order->shop->branch_name }}
                                        </span>
                                    </td>

                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light text-primary" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $order->id }}"><i
                                                class="fa-solid bi bi-pen"></i></button>

                                    </td>
                                </tr>
                                {{--  Edit --}}
                                <div class="modal fade" data-bs-backdrop="static" id="edit{{ $order->id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-success">
                                                    <i class="fa-solid fa-triangle-exclamation"></i> ยืนยันสถานะการติดตั้ง
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                การติดตั้งเสร็จสิ้นแล้วใช่ไหม ? <br>
                                                <small class="text-muted">คุณต้องการยืนยันสถานะการติดตั้งใช่ไหม ?</small>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">ยกเลิก</button>
                                                <a href="{{ url('admin/confirm-status') }}/{{ $order->id }}"
                                                    class="btn btn-success">ยืนยันสถานะการติดตั้ง</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 text-light"></i><br>
                                        ไม่มีคิวนัดหมายสำหรับวันที่เลือก
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
