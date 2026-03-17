@extends('backend/layouts/template')

@section('content')
    <div class="app-content">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">จัดการแบรนด์สินค้า</h4>
                </div>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                    <i class="fa-solid fa-plus me-1"></i> เพิ่มแบรนด์ใหม่
                </button>
            </div>
            <form action="{{ route('search.brand') }}" method="GET">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body bg-light p-3">
                        <div class="row g-2">
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input name="brand" type="text" class="form-control border-start-0"
                                        placeholder="ค้นหาชื่อแบรนด์..." value="{{ request('brand') }}">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <select name="status" class="form-select">
                                    <option value="all">สถานะทั้งหมด</option>

                                    <option value="เปิดใช้งาน" {{ request('status') == 'เปิดใช้งาน' ? 'selected' : '' }}>
                                        เปิดใช้งาน
                                    </option>

                                    <option value="ปิดใช้งาน" {{ request('status') == 'ปิดใช้งาน' ? 'selected' : '' }}>
                                        ปิดใช้งาน
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-md btn-primary w-100">
                                    <i class="bi bi-search me-1"></i> ค้นหา
                                </button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{ route('brands.index') }}" class="btn btn-md btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> ล้างค่า
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card border-0 shadow-sm">
                <div class="mt-3">
                    {{ $product_brands->links() }}
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4" style="width: 100px;">โลโก้</th>
                                <th>ชื่อแบรนด์</th>
                                <th>สินค้าในระบบ</th>
                                <th>สถานะ</th>
                                <th class="text-end pe-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_brands as $product_brand => $value)
                                <tr>
                                    <td class="ps-4">
                                        <div class="brand-logo-box">
                                            <img src="{{ asset('/image_upload/brand_image') }}/{{ $value->brand_image }}"
                                                class="img-responsive" width="100%">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $value->brand_name }}</div>
                                        <small class="text-muted">Slug : {{ $value->slug }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold">{{ $value->tire_specs_count }}</span> <span
                                                class="text-muted small">รายการ</span>
                                            <a href="#" class="text-decoration-none small"><i
                                                    class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark">{{ $value->status }}</div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light text-primary" data-bs-toggle="modal"
                                            data-bs-target="#editBrandModal{{ $value->id }}"><i
                                                class="fa-solid bi bi-pen"></i></button>
                                        <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deletebrandModal{{ $value->id }}"><i
                                                class="fa-solid bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <div class="modal fade" data-bs-backdrop="static" id="editBrandModal{{ $value->id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ url('admin/products/update-product-brand') }}"
                                                enctype="multipart/form-data">@csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">เพิ่มแบรนด์สินค้าใหม่</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">ชื่อแบรนด์ <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="brand_name"
                                                                    value="{{ $value->brand_name }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">URL Slug</label>
                                                                <input type="text" class="form-control bg-light"
                                                                    name="slug" value="{{ $value->slug }}">
                                                            </div>

                                                            <div class="mb-3 position-relative">
                                                                <label class="form-label small fw-bold">โลโก้แบรนด์
                                                                    (1:1)
                                                                </label>

                                                                <div class="preview-container border rounded p-3 text-center bg-light"
                                                                    style="cursor: pointer; min-height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center;">

                                                                    <div class="default-content">
                                                                        <i
                                                                            class="fa-solid fa-cloud-arrow-up upload-icon fs-2 text-secondary"></i>
                                                                        <p class="mb-1 fw-bold mt-2">คลิก หรือ
                                                                            ลากไฟล์รูปมาวางที่นี่</p>
                                                                        <small class="text-muted">รองรับไฟล์ JPG, PNG
                                                                            ขนาดไม่เกิน 2MB</small>
                                                                    </div>
                                                                </div>

                                                                <input type="file" name="brand_image"
                                                                    accept="image/png, image/jpeg"
                                                                    style="opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor: pointer;"
                                                                    onchange="previewImage(this)">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">สถานะ</label>
                                                                <select name="status" class="form-control">
                                                                    <option value="เปิดใช้งาน"
                                                                        {{ $value->status == 'เปิดใช้งาน' ? 'selected' : '' }}>
                                                                        เปิดใช้งาน
                                                                    </option>
                                                                    <option value="ปิดใช้งาน"
                                                                        {{ $value->status == 'ปิดใช้งาน' ? 'selected' : '' }}>
                                                                        ปิดใช้งาน
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="id" value="{{ $value->id }}">
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">ยกเลิก</button>
                                                    <button type="submit"
                                                        class="btn btn-warning fw-bold px-4">แก้ไขข้อมูล</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" data-bs-backdrop="static"
                                    id="deletebrandModal{{ $value->id }}" tabindex="-1">
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
                                                <a href="{{ url('admin/products/delete-product-brand') }}/{{ $value->id }}"
                                                    class="btn btn-danger">ยืนยันลบข้อมูล</a>
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
                {{ $product_brands->links() }}
            </div>
        </div>

        <div class="modal fade" data-bs-backdrop="static" id="addBrandModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ url('admin/products/create-product-brand') }}"
                        enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">เพิ่มแบรนด์สินค้าใหม่</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">ชื่อแบรนด์ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="brand_name"
                                            placeholder="เช่น MICHELIN หรือ BF GOODRICH">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">URL Slug</label>
                                        <input type="text" class="form-control bg-light" name="slug"
                                            placeholder="เช่น michelin หรือ bfgoodrich">
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <label class="form-label small fw-bold">โลโก้แบรนด์</label>

                                        <div class="preview-container border rounded p-3 text-center bg-light"
                                            style="cursor: pointer; min-height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center;">

                                            <div class="default-content">
                                                <i class="fa-solid fa-cloud-arrow-up upload-icon fs-2 text-secondary"></i>
                                                <p class="mb-1 fw-bold mt-2">คลิก หรือ ลากไฟล์รูปมาวางที่นี่</p>
                                                <small class="text-muted">รองรับไฟล์ JPG, PNG ขนาดไม่เกิน 2MB</small>
                                            </div>
                                        </div>

                                        <input type="file" name="brand_image" accept="image/png, image/jpeg"
                                            style="opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor: pointer;"
                                            onchange="previewImage(this)">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">สถานะ</label>
                                        <select class="form-select" name="status">
                                            <option value="เปิดใช้งาน">เปิดใช้งาน</option>
                                            <option value="ปิดใช้งาน">ปิดใช้งาน</option>
                                        </select>
                                    </div>
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
    <script>
        function previewImage(input) {
            const parentDiv = input.closest('.position-relative');
            const previewContainer = parentDiv.querySelector('.preview-container');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewContainer.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-fluid rounded shadow-sm" style="max-height: 200px; max-width: 100%;">
                        <p class="mt-2 text-success small fw-bold"><i class="fa-solid fa-check-circle"></i> อัพโหลดไฟล์สำเร็จ : ${file.name}</p>
                    </div>
                `;
                    previewContainer.classList.remove('bg-light');
                    previewContainer.classList.add('bg-white');
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.innerHTML = `
                <div class="default-content">
                    <i class="fa-solid fa-cloud-arrow-up upload-icon fs-2 text-secondary"></i>
                    <p class="mb-1 fw-bold mt-2">คลิก หรือ ลากไฟล์รูปมาวางที่นี่</p>
                    <small class="text-muted">รองรับไฟล์ JPG, PNG ขนาดไม่เกิน 2MB</small>
                </div>
            `;
                previewContainer.classList.add('bg-light');
                previewContainer.classList.remove('bg-white');
            }
        }
    </script>
@endsection
