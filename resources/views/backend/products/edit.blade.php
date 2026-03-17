@extends('backend/layouts/template')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('products.update') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="d-flex justify-content-between align-items-center mb-4 sticky-top bg-light py-2"
                    style="z-index: 99;">
                    <div>
                        <h4 class="fw-bold mb-1">แก้ไขข้อมูลสินค้า</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="fa-solid fa-save me-2"></i> อัพเดตข้อมูลสินค้า
                        </button>
                    </div>
                </div>
                <div class="row g-4">

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">SKU (รหัสสินค้า)</label>
                                    <input type="text" name="sku" class="form-control"value="{{ $product->sku }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">แบรนด์ (Brand)</label>
                                    <select class="form-select" name="brand_id" id="brand_select">
                                        <option selected disabled>-- เลือกยี่ห้อ --</option>
                                        @foreach ($product_brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ isset($product->tireSpec) && $product->tireSpec->brand_id == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->brand_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">รุ่น (Model)</label>
                                    <select class="form-select" name="model_id" id="model_select">
                                        <option value="" selected disabled>-- เลือกรุ่น --</option>
                                        @if (isset($product_models))
                                            @foreach ($product_models as $model)
                                                <option value="{{ $model->id }}"
                                                    {{ isset($product->tireSpec) && $product->tireSpec->model_id == $model->id ? 'selected' : '' }}>
                                                    {{ $model->model_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">เลือกประเภทรถยนต์ <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" name="type_car">
                                            <option disabled>-- เลือกประเภทรถยนต์ --</option>
                                            <option
                                                {{ $product->tireSpec->type_car == 'รถเก๋ง รถสปอร์ต' ? 'selected' : '' }}>
                                                รถเก๋ง รถสปอร์ต
                                            </option>
                                            <option
                                                {{ $product->tireSpec->type_car == 'รถ SUV รถอเนกประสงค์' ? 'selected' : '' }}>
                                                รถ SUV รถอเนกประสงค์
                                            </option>
                                            <option
                                                {{ $product->tireSpec->type_car == 'รถกระบะ รถตู้' ? 'selected' : '' }}>
                                                รถกระบะ รถตู้
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">RUNFLAT</label>
                                        <select class="form-select" name="runflat">
                                            <option value="ไม่ใช่" {{ $product->tireSpec->runflat == 'ไม่ใช่' ? 'selected' : '' }}>
                                                ไม่ใช่</option>
                                            <option value="ใช่" {{ $product->tireSpec->runflat == 'ใช่' ? 'selected' : '' }}>
                                                ใช่
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">ยางรถยนต์ EV</label>
                                        <select class="form-select" name="ev">
                                            <option value="ไม่ใช่" {{ $product->tireSpec->ev == 'ไม่ใช่' ? 'selected' : '' }}>
                                                ไม่ใช่</option>
                                            <option value="ใช่" {{ $product->tireSpec->ev == 'ใช่' ? 'selected' : '' }}>ใช่
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">คุณสมบัติเด่น
                                        (เลือกได้มากกว่า 1)
                                    </label>
                                    <div class="d-flex flex-wrap gap-3">
                                        @php
                                            $currentFeatures = is_array($product->tireSpec->features)
                                                ? $product->tireSpec->features
                                                : explode(',', $product->tireSpec->features ?? '');
                                        @endphp

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="Silent"
                                                {{ in_array('Silent', $currentFeatures) ? 'checked' : '' }}>
                                            <label class="form-check-label">นุ่มเงียบ</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="Sport"
                                                {{ in_array('Sport', $currentFeatures) ? 'checked' : '' }}>
                                            <label class="form-check-label">สปอร์ต/เกาะถนน</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="Save"
                                                {{ in_array('Save', $currentFeatures) ? 'checked' : '' }}>
                                            <label class="form-check-label">ประหยัดน้ำมัน</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="Wet"
                                                {{ in_array('Wet', $currentFeatures) ? 'checked' : '' }}>
                                            <label class="form-check-label">เบรกสั้น
                                                (เปียก)</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]"
                                                value="Offroad"
                                                {{ in_array('Offroad', $currentFeatures) ? 'checked' : '' }}>
                                            <label class="form-check-label">Off-road</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">กำหนดขนาดยาง</h6>

                                <div class="mb-3">
                                    <label class="form-label">ขนาดยาง (พิมพ์ค้นหาได้)</label>

                                    <select name="tire_size_id" id="tire_select" class="form-select" required>
                                        <option value="">-- พิมพ์เพื่อค้นหา --</option>
                                        @foreach ($tire_sizes as $size)
                                            @php
                                                $currentSize = '';
                                                if (isset($product->tireSpec)) {
                                                    $currentSize =
                                                        $product->tireSpec->width .
                                                        '/' .
                                                        $product->tireSpec->ratio .
                                                        'R' .
                                                        $product->tireSpec->rim;
                                                }
                                            @endphp
                                            <option value="{{ $size->id }}"
                                                {{ $currentSize == $size->size ? 'selected' : '' }}>

                                                {{ $size->size }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label class="form-label">ดัชนีรับน้ำหนัก (Load Index)</label>
                                        <input type="number" name="load_index" class="form-control"
                                            value="{{ $product->tireSpec->load_index }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">สัญลักษณ์ความเร็ว (Speed Symbol)</label>
                                        <input type="text" name="speed_symbol" class="form-control"
                                            value="{{ $product->tireSpec->speed_symbol }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">ราคาและคลังสินค้า</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">ราคาต้นทุน (บาท)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="cost_price"
                                                value="{{ $product->cost_price }}">
                                            <span class="input-group-text">฿</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">ราคาขายปกติ (บาท)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="price"
                                                value="{{ $product->price }}">
                                            <span class="input-group-text">฿</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-danger">ราคาโปรโมชั่น (ถ้ามี)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control border-danger" name="sale_price"
                                                value="{{ $product->sale_price }}">
                                            <span class="input-group-text bg-danger text-white">฿</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label">ปีผลิต</label>
                                        <input type="text" class="form-control" name="year"
                                            value="{{ $product->tireSpec->year }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">DOT</label>
                                        <input type="text" class="form-control" name="dot"
                                            value="{{ $product->tireSpec->dot }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">สถานะสินค้า</label>
                                        <select class="form-select mb-3" name="is_active">
                                            <option value="1" {{ $product->is_active == '1' ? 'selected' : '' }}>
                                                เปิดขาย
                                            </option>
                                            <option value="0" {{ $product->is_active == '0' ? 'selected' : '' }}>
                                                ปิด
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">สินค้าแนะนำ</label>
                                        <select class="form-select mb-3" name="is_featured">
                                            <option value="0" {{ $product->is_featured == '0' ? 'selected' : '' }}>
                                                ไม่
                                            </option>
                                            <option value="1" {{ $product->is_featured == '1' ? 'selected' : '' }}>
                                                ใช่
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tire_select').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: "-- พิมพ์เพื่อค้นหา --",
                allowClear: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#brand_select').on('change', function() {
                var brandId = $(this).val();

                if (brandId) {
                    $.ajax({
                        url: '../../../get-models/' + brandId, 
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#model_select').empty();
                            $('#model_select').append(
                                '<option value="" selected disabled>-- เลือกรุ่น --</option>'
                            );

                            $('#model_select').prop('disabled', false);

                            $.each(data, function(key, value) {
                                $('#model_select').append('<option value="' + value.id +
                                    '">' + value.model_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#model_select').empty();
                    $('#model_select').append(
                        '<option value="" selected disabled>-- กรุณาเลือกยี่ห้อก่อน --</option>');
                    $('#model_select').prop('disabled', true);
                }
            });
        });
    </script>
@endsection
