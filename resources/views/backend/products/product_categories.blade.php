@extends('backend/layouts/template')

@section('content')
    @php
        $all_category = Count($product_categories);
        $category_active = DB::table('product_categories')->where('status', 'เปิดใช้งาน')->count();
        $category_not_active = DB::table('product_categories')->where('status', 'ปิดใช้งาน')->count();
    @endphp
    <div class="app-content">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">หมวดหมู่สินค้า</h4>
                </div>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="fa-solid fa-plus me-1"></i> เพิ่มหมวดหมู่
                </button>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                            <i class="fa-solid fa-layer-group fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $all_category }}</h5>
                            <small class="text-muted">หมวดหมู่ทั้งหมด</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 text-success rounded p-3">
                            <i class="fa-solid fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $category_active }}</h5>
                            <small class="text-muted">ใช้งานอยู่ (Active)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center gap-3">
                        <div class="bg-danger bg-opacity-10 text-secondary rounded p-3">
                            <i class="fa-solid fa-eye-slash fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $category_not_active }}</h5>
                            <small class="text-muted">ซ่อนไว้ (Hidden)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-5">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th>ชื่อหมวดหมู่</th>
                                <th>Slug (URL)</th>
                                <th>สถานะ</th>
                                <th class="text-end pe-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_categories as $product_category => $value)
                                <tr class="category-row bg-light bg-opacity-25">
                                    <td>
                                        <div class="fw-bold text-dark">{{ $value->category }}</div>
                                    </td>
                                    <td><code class="text-muted">{{ $value->slug }}</code></td>
                                    <td>
                                        @if ($value->status == 'เปิดใช้งาน')
                                            <div class="text-dark">
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success border border-success">{{ $value->status }}</span>
                                            </div>
                                        @elseif($value->status == 'ปิดใช้งาน')
                                            <div class="text-dark">
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger border border-danger">{{ $value->status }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light text-primary" data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal{{ $value->id }}"><i
                                                class="fa-solid bi bi-pen"></i></button>
                                        <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteCategoryModal{{ $value->id }}"><i
                                                class="fa-solid bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                {{--  Edit Cagetory Model --}}
                                <div class="modal fade" data-bs-backdrop="static" id="editCategoryModal{{ $value->id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST"
                                                action="{{ url('admin/products/edit-product-categories') }}"
                                                enctype="multipart/form-data">@csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">แก้ไขหมวดหมู่สินค้า</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">ชื่อหมวดหมู่ <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="category" class="form-control"
                                                            value="{{ $value->category }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Slug (URL) <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="slug" class="form-control"
                                                            value="{{ $value->slug }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">สถานะ</label>
                                                        <select class="form-select text-secondary" name="status">
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
                                                    <input type="hidden" name="id" value="{{ $value->id }}">

                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">ยกเลิก</button>
                                                    <button type="submit"
                                                        class="btn btn-warning fw-bold px-4">บันทึก</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" data-bs-backdrop="static" id="deleteCategoryModal{{ $value->id }}" tabindex="-1">
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
                                                <a href="{{ url('admin/products/delete-product-categories') }}/{{ $value->id }}"
                                                    class="btn btn-danger">ยืนยันลบข้อมูล</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{--  Add Cagetory Model --}}
                            <div class="modal fade" data-bs-backdrop="static" id="addCategoryModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form method="POST"
                                            action="{{ url('admin/products/create-product-categories') }}"
                                            enctype="multipart/form-data">@csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">เพิ่มหมวดหมู่ใหม่</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">ชื่อหมวดหมู่ <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="category" class="form-control"
                                                        placeholder="เช่น ยางรถยนต์">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Slug (URL) <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="slug" class="form-control"
                                                        placeholder="เช่น tires">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">สถานะ</label>
                                                    <select class="form-select text-secondary" name="status">
                                                        <option value="เปิดใช้งาน">เปิดใช้งาน</option>
                                                        <option value="ปิดใช้งาน">ปิดใช้งาน</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit"
                                                    class="btn btn-warning fw-bold px-4">บันทึก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
