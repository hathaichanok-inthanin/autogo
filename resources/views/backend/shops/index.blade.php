@extends('backend/layouts/template')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="app-content">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">รายชื่อร้านค้า</h4>
                    <span class="text-muted small">จัดการข้อมูลร้านค้า</span>
                </div>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addShopModal">
                    <i class="fa-solid fa-store me-1"></i> เพิ่มร้านค้าใหม่
                </button>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body bg-light p-3">
                    <form action="{{ route('shops.index') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="text" class="form-control border-start-0"
                                        placeholder="ค้นหาชื่อร้าน, เบอร์โทร, จังหวัด..." name="search"
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <select name="status" class="form-select">
                                    <option value="all">สถานะทั้งหมด</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>เปิดให้บริการ
                                    </option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>ปิดให้บริการ
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <button class="btn btn-dark w-100">ค้นหา</button>
                            </div>
                            <div class="col-lg-1">
                                <a href="{{ route('shops.index') }}" class="btn btn-md btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> ล้างค่า
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="mt-3">
                    {{ $shops->links() }}
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4">ชื่อร้านค้า / สาขา</th>
                                <th>E-mail / เบอร์โทร</th>
                                <th>ที่ตั้ง / ผู้ติดต่อ</th>
                                <th>วันเวลาเปิด-ปิด</th>
                                <th>สถานะร้าน</th>
                                <th class="text-end pe-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shops as $shop)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div>
                                                <div class="text-dark fs-6 d-flex align-items-center">
                                                    {{ $shop->shop_name }}
                                                    @if ($shop->branch_name)
                                                        <span
                                                            class="ms-1 text-muted fw-normal">({{ $shop->branch_name }})</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark">
                                                {{ $shop->email }}
                                            </span>
                                            <span class="small text-muted mt-1">
                                                {{ $shop->phone ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark">
                                                {{ $shop->address_text }} ตำบล{{ $shop->subdistrict }}
                                                อำเภอ{{ $shop->district }} {{ $shop->province }} {{ $shop->zipcode }}
                                            </span>
                                            <span class="small text-muted mt-1">
                                                {{ $shop->latitude }}
                                                {{ $shop->longitude }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark">
                                                เปิดบริการ{{ $shop->business_days }}
                                            </span>
                                            <span class="small text-muted mt-1">
                                                เวลา {{ $shop->open_time }}-{{ $shop->close_time }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            @if ($shop->is_active)
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" checked
                                                        disabled>
                                                </div>
                                            @else
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" disabled>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            {{-- ปุ่ม Link ไป Google Maps --}}
                                            @if ($shop->google_maps_link)
                                                <a href="{{ $shop->google_maps_link }}" target="_blank"
                                                    class="btn btn-sm btn-outline-secondary rounded-pill me-1"
                                                    data-bs-toggle="tooltip" title="เปิดแผนที่">
                                                    <i class="fa-solid bi bi-map"></i>
                                                </a>
                                            @endif

                                            <button class="btn btn-sm btn-light text-primary me-1" data-bs-toggle="modal"
                                                data-bs-target="#editShop{{ $shop->id }}"><i
                                                    class="fa-solid bi bi-pen"></i></button>
                                            <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteShop{{ $shop->id }}"><i
                                                    class="fa-solid bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" data-bs-backdrop="static" id="deleteShop{{ $shop->id }}"
                                    tabindex="-1">
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

                                            <form action="{{ route('shops.destroy', $shop->id) }}" method="POST"
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
                                <div class="modal fade" data-bs-backdrop="static" id="editShop{{ $shop->id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">แก้ไขข้อมูลร้านค้า</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('shops.edit') }}" method="POST"
                                                enctype="multipart/form-data">@csrf
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <h6 class="fw-bold text-muted small border-bottom pb-2">
                                                                ข้อมูลร้านค้า
                                                            </h6>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">รูปภาพหน้าร้าน <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="file" class="form-control" name="shop_image"
                                                                accept="image/*">
                                                            <div class="form-text small">รองรับไฟล์ .jpg, .png ขนาดไม่เกิน
                                                                2MB</div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">ชื่อร้านค้า <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="shop_name"
                                                                value="{{ $shop->shop_name }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">ชื่อสาขา (ถ้ามี)</label>
                                                            <input type="text" class="form-control" name="branch_name"
                                                                value="{{ $shop->branch_name }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">เบอร์โทรศัพท์ร้าน</label>
                                                            <input type="text" class="form-control" name="phone"
                                                                value="{{ $shop->phone }}">
                                                        </div>

                                                        <div class="col-md-6 d-flex align-items-end">
                                                            <div class="form-check form-switch mb-2">
                                                                <input type="hidden" name="is_active" value="0">

                                                                <input class="form-check-input" type="checkbox"
                                                                    id="isActiveSwitch_{{ $shop->id }}"
                                                                    name="is_active" value="1"
                                                                    {{ $shop->is_active ? 'checked' : '' }}>

                                                                <label class="form-check-label"
                                                                    for="isActiveSwitch_{{ $shop->id }}">
                                                                    เปิดให้บริการ (Active)
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mt-4">
                                                            <h6 class="fw-bold text-muted small border-bottom pb-2">
                                                                ที่ตั้งร้าน</h6>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">ที่อยู่ (เลขที่, หมู่บ้าน,
                                                                ถนน)</label>
                                                            <input type="text" class="form-control"
                                                                name="address_text" value="{{ $shop->address_text }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">ตำบล / แขวง <span
                                                                    class="text-danger">*</span></label>

                                                            <input type="text" class="form-control"
                                                                id="show_subdistrict_{{ $shop->id }}"
                                                                value="{{ $shop->subdistrict }}" autocomplete="off">

                                                            <input type="hidden" name="subdistrict"
                                                                id="subdistrict_{{ $shop->id }}"
                                                                value="{{ $shop->subdistrict }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">อำเภอ / เขต <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control"
                                                                id="show_district_{{ $shop->id }}"
                                                                value="{{ $shop->district }}" autocomplete="off">
                                                            <input type="hidden" name="district"
                                                                id="district_{{ $shop->id }}"
                                                                value="{{ $shop->district }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">จังหวัด <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control"
                                                                id="show_province_{{ $shop->id }}"
                                                                value="{{ $shop->province }}" autocomplete="off">
                                                            <input type="hidden" name="province"
                                                                id="province_{{ $shop->id }}"
                                                                value="{{ $shop->province }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">รหัสไปรษณีย์ <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control"
                                                                id="show_zipcode_{{ $shop->id }}"
                                                                value="{{ $shop->zipcode }}" required autocomplete="off">
                                                            <input type="hidden" name="zipcode"
                                                                id="zipcode_{{ $shop->id }}"
                                                                value="{{ $shop->zipcode }}">
                                                        </div>

                                                        <div class="col-12 mt-4">
                                                            <h6 class="fw-bold text-muted small border-bottom pb-2">
                                                                พิกัดแผนที่</h6>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Google Maps Link <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control"
                                                                name="google_maps_link"
                                                                value="{{ $shop->google_maps_link }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">ละติจูด (Latitude) <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="latitude"
                                                                value="{{ $shop->latitude }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">ลองจิจูด (Longitude) <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="longitude"
                                                                value="{{ $shop->longitude }}">
                                                        </div>

                                                        <div class="col-12 mt-4">
                                                            <h6 class="fw-bold text-muted small border-bottom pb-2">
                                                                วันและเวลาทำการ</h6>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">วันทำการ</label>
                                                            <input type="text" class="form-control"
                                                                name="business_days" value="{{ $shop->business_days }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">เวลาเปิด</label>
                                                            <input type="time" class="form-control" name="open_time"
                                                                value="{{ $shop->open_time }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">เวลาปิด</label>
                                                            <input type="time" class="form-control" name="close_time"
                                                                value="{{ $shop->close_time }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">ยกเลิก</button>
                                                    <input type="hidden" name="id" value="{{ $shop->id }}">
                                                    <button type="submit"
                                                        class="btn btn-warning fw-bold px-4">แก้ไขข้อมูลร้านค้า</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                {{-- กรณีไม่มีข้อมูล --}}
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-store-slash fa-2x mb-3 opacity-50"></i><br>
                                        ยังไม่มีข้อมูลร้านค้าในระบบ
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $shops->links() }}
                </div>
            </div>

        </div>

        <div class="modal fade" data-bs-backdrop="static" id="addShopModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">เพิ่มร้านค้าพาร์ทเนอร์ใหม่</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('shops.store') }}" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <h6 class="fw-bold text-muted small border-bottom pb-2">ข้อมูลร้านค้า & บัญชีผู้ใช้
                                    </h6>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">รูปภาพหน้าร้าน <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="shop_image" accept="image/*">
                                    <div class="form-text small">รองรับไฟล์ .jpg, .png ขนาดไม่เกิน 2MB</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ชื่อร้านค้า <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="shop_name"
                                        placeholder="เช่น ไทร์พลัส เอกการยาง" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ชื่อสาขา (ถ้ามี)</label>
                                    <input type="text" class="form-control" name="branch_name"
                                        placeholder="เช่น สาขาโคกกลอย">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">เบอร์โทรศัพท์ร้าน</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>

                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="isActiveSwitch"
                                            name="is_active" value="1" checked>
                                        <label class="form-check-label" for="isActiveSwitch">เปิดให้บริการ
                                            (Active)</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">อีเมล (สำหรับ Login) <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">รหัสผ่าน <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>

                                <div class="col-12 mt-4">
                                    <h6 class="fw-bold text-muted small border-bottom pb-2">ที่ตั้งร้าน</h6>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">ที่อยู่ (เลขที่, หมู่บ้าน, ถนน)</label>
                                    <input type="text" class="form-control" name="address_text">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ตำบล / แขวง <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="subdistrict" id="subdistrict">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">อำเภอ / เขต <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="district" id="district">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">จังหวัด <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="province" id="province">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="zipcode" id="zipcode" required>
                                </div>

                                <div class="col-12 mt-4">
                                    <h6 class="fw-bold text-muted small border-bottom pb-2">พิกัดแผนที่</h6>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Google Maps Link <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="google_maps_link"
                                        placeholder="https://goo.gl/maps/...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ละติจูด (Latitude) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="latitude"
                                        placeholder="เช่น 13.756330">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ลองจิจูด (Longitude) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="longitude"
                                        placeholder="เช่น 100.501765">
                                </div>

                                <div class="col-12 mt-4">
                                    <h6 class="fw-bold text-muted small border-bottom pb-2">วันและเวลาทำการ</h6>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">วันทำการ</label>
                                    <input type="text" class="form-control" name="business_days"
                                        placeholder="เช่น จันทร์ - เสาร์">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">เวลาเปิด</label>
                                    <input type="time" class="form-control" name="open_time">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">เวลาปิด</label>
                                    <input type="time" class="form-control" name="close_time">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-warning fw-bold px-4">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- ที่อยู่ --}}
    <script type="text/javascript"
        src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
    <script type="text/javascript"
        src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
    <link rel="stylesheet"
        href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <script type="text/javascript"
        src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>

    <script>
        $(document).ready(function() {
            $.Thailand({
                $district: $('#subdistrict'),
                $amphoe: $('#district'),
                $province: $('#province'),
                $zipcode: $('#zipcode'),
            });

            $(document).on('shown.bs.modal', '.modal', function() {
                var modalId = $(this).attr('id');
                if (modalId && modalId.startsWith('editShop')) {
                    var id = modalId.replace('editShop', '');

                    if (!$(this).data('thailand-init')) {

                        var $show_district = $('#show_subdistrict_' + id);
                        var $show_amphoe = $('#show_district_' + id);
                        var $show_province = $('#show_province_' + id);
                        var $show_zipcode = $('#show_zipcode_' + id);

                        var $real_district = $('#subdistrict_' + id);
                        var $real_amphoe = $('#district_' + id);
                        var $real_province = $('#province_' + id);
                        var $real_zipcode = $('#zipcode_' + id);

                        function updateRealInputs() {
                            $real_district.val($show_district.val());
                            $real_amphoe.val($show_amphoe.val());
                            $real_province.val($show_province.val());
                            $real_zipcode.val($show_zipcode.val());
                        }

                        $.Thailand({
                            $district: $show_district,
                            $amphoe: $show_amphoe,
                            $province: $show_province,
                            $zipcode: $show_zipcode,

                            onDataFill: function(data) {
                                $show_district.val(data.district);
                                $show_amphoe.val(data.amphoe);
                                $show_province.val(data.province);
                                $show_zipcode.val(data.zipcode);

                                updateRealInputs();
                            }
                        });

                        $show_district.change(updateRealInputs);
                        $show_amphoe.change(updateRealInputs);
                        $show_province.change(updateRealInputs);
                        $show_zipcode.change(updateRealInputs);

                        $(this).data('thailand-init', true);
                    }
                }
            });
        });
    </script>
@endsection
