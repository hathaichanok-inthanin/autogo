@extends('backend/layouts/template')

@section('content')
    <div class="app-content">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">จัดการรุ่นสินค้า</h4>
                </div>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModelModal">
                    <i class="fa-solid fa-plus me-1"></i> เพิ่มรุ่นใหม่
                </button>
            </div>

            <form action="{{ route('search.model') }}" method="GET">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body bg-light p-3">
                        <div class="row g-2">

                            <div class="col-lg-3">
                                <label class="small text-muted mb-1">ค้นหารุ่น</label>
                                <div class="input-group">
                                    <input type="text" name="model_name" class="form-control border-start-0"
                                        placeholder="เช่น Primacy 4..." value="{{ request('model_name') }}">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <label class="small text-muted mb-1">แบรนด์</label>
                                <select class="form-select" name="brand">
                                    <option value="all">ทุกแบรนด์</option>
                                    @foreach ($product_brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label class="small text-muted mb-1">ประเภทรถ</label>
                                <select class="form-select" name="typecar">
                                    <option value="all">ทั้งหมด</option>

                                    <option value="รถเก๋ง รถสปอร์ต"
                                        {{ request('typecar') == 'รถเก๋ง รถสปอร์ต' ? 'selected' : '' }}>
                                        รถเก๋ง รถสปอร์ต
                                    </option>

                                    <option value="รถ SUV รถอเนกประสงค์"
                                        {{ request('typecar') == 'รถ SUV รถอเนกประสงค์' ? 'selected' : '' }}>
                                        รถ SUV รถอเนกประสงค์
                                    </option>

                                    <option value="รถกระบะ รถตู้"
                                        {{ request('typecar') == 'รถกระบะ รถตู้' ? 'selected' : '' }}>
                                        รถกระบะ รถตู้
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-dark w-100">
                                    <i class="fa-solid fa-filter me-1"></i> กรองข้อมูล
                                </button>
                                <a href="{{ route('product_models.index') }}"
                                    class="btn btn-md btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> ล้างค่า
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>

            <div class="card border-0 shadow-sm">
                <div class="mt-3">
                    {{ $product_models->links() }}
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 120px;">ลายดอกยาง</th>
                                <th>ชื่อแบรนด์</th>
                                <th>ชื่อรุ่น</th>
                                <th>จำนวน SKU</th>
                                <th class="text-end pe-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_models as $product_model => $value)
                                @php
                                    $brand_name = DB::table('brands')
                                        ->where('id', $value->brand_id)
                                        ->value('brand_name');
                                @endphp
                                <tr>
                                    <td style="width: 60px;">
                                        <img src="{{ asset('/image_upload/model_image') }}/{{ $value->model_image }}"
                                            class="img-responsive" width="100%">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="text-dark fw-bold">{{ $brand_name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark fs-6">{{ $value->model_name }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary rounded-pill">{{ $value->tire_specs_count }}
                                            SKU</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light text-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $value->id }}"><i
                                                class="fa-solid bi bi-pen"></i></button>
                                        <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $value->id }}"><i
                                                class="fa-solid bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <div class="modal fade" data-bs-backdrop="static" id="deleteModal{{ $value->id }}"
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
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">ยกเลิก</button>
                                                <a href="{{ url('admin/products/delete-product-model') }}/{{ $value->id }}"
                                                    class="btn btn-danger">ยืนยันลบข้อมูล</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" data-bs-backdrop="static" id="editModal{{ $value->id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ url('admin/products/update-product-model') }}"
                                                enctype="multipart/form-data">@csrf

                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">แก้ไขรุ่นสินค้า (Model):
                                                        {{ $value->model_name }}</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-8">
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">เลือกแบรนด์ <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="form-select" name="brand_id">
                                                                        <option disabled>-- เลือกยี่ห้อ --</option>
                                                                        @foreach ($product_brands as $brand)
                                                                            <option value="{{ $brand->id }}"
                                                                                {{ $value->brand_id == $brand->id ? 'selected' : '' }}>
                                                                                {{ $brand->brand_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label">ชื่อรุ่น <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="เช่น Primacy 4" name="model_name"
                                                                        value="{{ $value->model_name }}">
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <div class="col-md-12">
                                                                    <label class="form-label fw-bold">สถานะ</label>
                                                                    <select class="form-select" name="status">
                                                                        <option value="เปิดใช้งาน"
                                                                            {{ $value->status == 'เปิดใช้งาน' ? 'selected' : '' }}>
                                                                            เปิดใช้งาน</option>
                                                                        <option value="ปิดใช้งาน"
                                                                            {{ $value->status == 'ปิดใช้งาน' ? 'selected' : '' }}>
                                                                            ปิดใช้งาน</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold small">รูปดอกยาง</label>
                                                            <div class="mb-3 position-relative">

                                                                <div id="preview-container-{{ $value->id }}"
                                                                    class="border rounded p-3 text-center bg-light"
                                                                    style="cursor: pointer; min-height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center;">

                                                                    <div id="default-content-{{ $value->id }}">
                                                                        <i
                                                                            class="fa-solid fa-image upload-icon fs-2 text-secondary"></i>
                                                                        <p class="mb-1 fw-bold mt-2">คลิกเพื่ออัปโหลดรูปภาพ
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <input type="file" name="model_image"
                                                                    accept="image/png, image/jpeg"
                                                                    style="opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor: pointer;"
                                                                    onchange="previewImage(this, 'preview-container-{{ $value->id }}', 'default-content-{{ $value->id }}')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">ยกเลิก</button>
                                                    <input type="hidden" name="id" value="{{ $value->id }}">
                                                    <button type="submit"
                                                        class="btn btn-warning fw-bold px-4">บันทึกการแก้ไข</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $product_models->links() }}
                </div>
            </div>
        </div>

        <div class="modal fade" data-bs-backdrop="static" id="addModelModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ url('admin/products/create-product-model') }}"
                        enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">เพิ่มรุ่นสินค้า (Model)</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">เลือกแบรนด์ <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" name="brand_id">
                                                <option selected disabled>-- เลือกยี่ห้อ --</option>
                                                @foreach ($product_brands as $product_brand => $value)
                                                    <option value="{{ $value->id }}">{{ $value->brand_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">ชื่อรุ่น <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="เช่น Primacy 4"
                                                name="model_name">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">สถานะ</label>
                                            <select class="form-select" name="status">
                                                <option value="เปิดใช้งาน">เปิดใช้งาน</option>
                                                <option value="ปิดใช้งาน">ปิดใช้งาน</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold small">รูปดอกยาง</label>
                                    <div class="mb-3 position-relative">

                                        <div id="preview-container-1" class="border rounded p-3 text-center bg-light"
                                            style="cursor: pointer; min-height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center;">

                                            <div id="default-content-1">
                                                <i class="fa-solid fa-cloud-arrow-up upload-icon fs-2 text-secondary"></i>
                                                <p class="mb-1 fw-bold mt-2">คลิกเพื่ออัปโหลดรูปภาพ</p>
                                            </div>
                                        </div>

                                        <input type="file" name="model_image" accept="image/png, image/jpeg"
                                            style="opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor: pointer;"
                                            onchange="previewImage(this, 'preview-container-1', 'default-content-1')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-warning fw-bold px-4">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(input, previewId, contentId) {
            const previewContainer = document.getElementById(previewId);
            const defaultContent = document.getElementById(contentId);
            const file = input.files[0];

            if (!previewContainer) {
                console.error('ไม่พบ Element ID: ' + previewId);
                return;
            }

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewContainer.innerHTML = `
                <div class="position-relative">
                    <img src="${e.target.result}" class="img-fluid rounded shadow-sm" style="max-height: 200px; max-width: 100%;">
                    <p class="mt-2 text-success small fw-bold"><i class="fa-solid fa-check-circle"></i> เลือกไฟล์สำเร็จ</p>
                </div>
                `;
                    previewContainer.classList.remove('bg-light');
                    previewContainer.classList.add('bg-white');
                }

                reader.readAsDataURL(file);
            } else {
                previewContainer.innerHTML = '';
                if (defaultContent) {
                    previewContainer.appendChild(defaultContent);
                }
                previewContainer.classList.add('bg-light');
                previewContainer.classList.remove('bg-white');
            }
        }
    </script>
@endsection
