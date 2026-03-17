@extends('backend/layouts/template')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">รายงานยอดขาย</h1>
    </div>

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('reports.sales') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small font-weight-bold">จากวันที่</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small font-weight-bold">ถึงวันที่</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small font-weight-bold">เลือกสาขา</label>
                    <select name="branch_id" class="form-select">
                        <option value="all" {{ $branchId == 'all' ? 'selected' : '' }}>ทุกสาขา</option>
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}" {{ $branchId == $shop->id ? 'selected' : '' }}>
                                {{$shop->shop_name}} {{ $shop->branch_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">กรองข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">ยอดขายรวม</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalSales, 2) }} บาท</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">จำนวนรายการ</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }} ออเดอร์</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">ยอดเฉลี่ยต่อบิล</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($avgOrderValue, 2) }} บาท</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">แนวโน้มยอดขายในช่วงเวลาที่เลือก</h6>
        </div>
        <div class="card-body">
            <canvas id="salesChart" width="100%" height="30"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->pluck('date')) !!},
            datasets: [{
                label: 'ยอดขาย (บาท)',
                data: {!! json_encode($chartData->pluck('sum')) !!},
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                fill: true,
                tension: 0.3
            }]
        }
    });
</script>
@endsection