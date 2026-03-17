@extends('backend/layouts/template')

@section('content')
    @php
        $count_product = Count($products);
    @endphp
    <div class="app-content">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">จัดการสินค้า</h4>
                    <span class="text-muted small">รายการสินค้าทั้งหมด ({{ $count_product }} รายการ)</span>
                </div>
                <a href="{{ url('admin/products/create') }}" class="btn btn-warning">
                    <i class="fa-solid fa-plus me-2"></i> เพิ่มสินค้าใหม่
                </a>
            </div>

            <div class="card mb-4 border-0 shadow-sm bg-light">
                <div class="card-body py-3">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="row g-2 align-items-end">

                            {{-- ค้นหาด่วน (ชื่อ/SKU) --}}
                            <div class="col-md-3">
                                <label class="form-label small text-muted">ค้นหาทั่วไป</label>
                                <input type="text" name="search" class="form-control form-control-md"
                                    placeholder="ชื่อสินค้า, SKU..." value="{{ request('search') }}">
                            </div>

                            {{-- ค้นหาขนาดเต็ม --}}
                            <div class="col-md-2">
                                <label class="form-label small text-muted">ระบุขนาดยาง</label>
                                <input type="text" name="full_size" class="form-control form-control-md bg-white"
                                    value="{{ request('full_size') }}">
                            </div>

                            {{-- กรองหน้ากว้าง (Width) --}}
                            <div class="col-md-2">
                                <label class="form-label small text-muted">หน้ากว้าง</label>
                                <select name="width" class="form-select form-select-md">
                                    <option value="">ทั้งหมด</option>
                                    @foreach ($widths as $w)
                                        <option value="{{ $w }}" {{ request('width') == $w ? 'selected' : '' }}>
                                            {{ $w }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- กรองขอบยาง (Rim) --}}
                            <div class="col-md-2">
                                <label class="form-label small text-muted">ขอบยาง (นิ้ว)</label>
                                <select name="rim" class="form-select form-select-md">
                                    <option value="">ทั้งหมด</option>
                                    @foreach ($rims as $r)
                                        <option value="{{ $r }}" {{ request('rim') == $r ? 'selected' : '' }}>
                                            ขอบ {{ $r }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-md btn-primary w-100">
                                    <i class="bi bi-search me-1"></i> ค้นหา
                                </button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{ route('products.index') }}" class="btn btn-md btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> ล้างค่า
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 80px;">รูปภาพ</th>
                                <th>ชื่อสินค้า / แบรนด์</th>
                                <th>ขนาดยาง</th>
                                <th>ราคาต้นทุน</th>
                                <th>ราคาขาย</th>
                                <th>ราคาโปรโมชั่น</th>
                                <th></th>
                                <th>คุณสมบัติเด่น (Features)</th>
                                <th>ประเภทรถ</th>
                                <th>สถานะ</th>
                                <th class="text-end pe-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                @php
                                    $featureMap = [
                                        'Silent' => ['text' => 'นุ่มเงียบ'],
                                        'Sport' => ['text' => 'สปอร์ต/เกาะถนน'],
                                        'Save' => ['text' => 'ประหยัดน้ำมัน'],
                                        'Wet' => ['text' => 'เบรกสั้น'],
                                        'Offroad' => ['text' => 'Off-road'],
                                    ];
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset('/image_upload/model_image') }}/{{ $product->tireSpec->model->model_image }}"
                                            class="img-responsive" width="100%">
                                    </td>
                                    <td>
                                        <div class="product-brand">{{ $product->tireSpec->brand->brand_name }}</div>
                                        <h6 class="product-name">{{ $product->tireSpec->model->model_name }}</h6>
                                        <small class="text-muted">ปียาง : {{ $product->tireSpec->year }} DOT :
                                            {{ $product->tireSpec->dot }}</small>
                                    </td>
                                    <td>
                                        <span
                                            class="tire-size-badge">{{ $product->tireSpec->width }}/{{ $product->tireSpec->ratio }}R{{ $product->tireSpec->rim }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ number_format($product->cost_price) }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ number_format($product->price) }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ number_format($product->sale_price) }}</div>
                                    </td>
                                    <td>
                                        {{-- ปุ่มดูประวัติราคา --}}
                                        <button type="button"
                                            class="btn btn-sm btn-light text-warning me-1 btn-view-history"
                                            data-id="{{ $product->id }}" title="ดูประวัติราคา" data-bs-toggle="modal"
                                            data-bs-target="#priceHistoryModal{{ $product->id }}">
                                            ประวัติราคา
                                        </button>
                                    </td>
                                    <td>
                                        @if (is_array($product->tireSpec->features) && count($product->tireSpec->features) > 0)
                                            @foreach ($product->tireSpec->features as $key)
                                                @if (isset($featureMap[$key]))
                                                    <span class="badge bg-danger">{{ $featureMap[$key]['text'] }}</span>
                                                @endif
                                            @endforeach
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-light text-dark border">{{ $product->tireSpec->type_car }}</span>
                                    </td>
                                    <td>
                                        @if ($product->is_active == '1')
                                            <div class="text-success">เปิดขาย</div>
                                        @elseif($product->is_active == '0')
                                            <div class="text-danger">ปิด</div>
                                        @endif
                                    </td>

                                    <td class="text-end pe-4">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-sm btn-light text-primary me-1"><i
                                                class="fa-solid bi bi-pen"></i></a>
                                        <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteProductTire{{ $product->id }}"><i
                                                class="fa-solid bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <div class="modal fade" data-bs-backdrop="static" id="deleteProductTire{{ $product->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger">
                                                    <i class="fa-solid fa-triangle-exclamation"></i> ยืนยันการลบ
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                คุณแน่ใจหรือไม่ที่จะลบรายการนี้? <br>
                                                <small class="text-muted">การกระทำนี้ไม่สามารถย้อนกลับได้</small>
                                            </div>

                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">ยกเลิก</button>
                                                    <button type="submit" class="btn btn-danger">ยืนยันลบข้อมูล</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" data-bs-backdrop="static"
                                    id="priceHistoryModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i
                                                        class="bi bi-clock-history me-2"></i>ประวัติการปรับราคา</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body" id="priceHistoryContent{{ $product->id }}">
                                                <div class="text-center py-4">
                                                    <div class="spinner-border text-primary" role="status"></div>
                                                    <p class="mt-2 text-muted">กำลังโหลดข้อมูล...</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-view-history').on('click', function() {
                let productId = $(this).data('id');

                let content = $('#priceHistoryContent' + productId);

                content.html(
                    '<div class="text-center py-4"><div class="spinner-border text-primary"></div><p class="mt-2">กำลังโหลด...</p></div>'
                );

                $.ajax({
                    url: '{{ url('admin/products/history') }}/' + productId,
                    type: 'GET',
                    success: function(response) {
                        content.html(response);
                    },
                    error: function() {
                        content.html(
                            '<div class="text-center text-danger py-4"><i class="bi bi-exclamation-triangle display-4"></i><p class="mt-2">เกิดข้อผิดพลาด ไม่สามารถโหลดข้อมูลได้</p></div>'
                        );
                    }
                });
            });
        });
    </script>
@endsection
