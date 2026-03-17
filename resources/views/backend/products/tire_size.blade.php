@extends('backend/layouts/template')
<style>
    .spec-badge {
        background-color: #212529;
        color: #FFD700;
        font-family: 'Prompt', 'Courier New', monospace;
        font-weight: bold;
        font-size: 16px;
        padding: 6px 12px;
        border-radius: 6px;
        letter-spacing: 1px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        display: inline-block;
    }

    .dim-box {
        display: inline-block;
        text-align: center;
        padding: 0 10px;
        border-right: 1px solid #ddd;
    }

    .dim-box:last-child {
        border-right: none;
    }

    .dim-label {
        font-size: 10px;
        color: #888;
        text-transform: uppercase;
    }

    .dim-value {
        font-weight: bold;
        font-size: 14px;
        color: #333;
    }
</style>
@section('content')
    <div class="app-content">


        <div class="container-fluid p-0">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">จัดการขนาดยาง</h4>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addSizeModal">
                        <i class="fa-solid fa-plus me-1"></i> เพิ่มขนาดใหม่
                    </button>
                </div>
            </div>

            <form action="{{ route('search.size') }}" method="GET">
                <div class="row g-2 align-items-end">
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
                        <a href="{{ route('tire_sizes.index') }}" class="btn btn-md btn-outline-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> ล้างค่า
                        </a>
                    </div>
                </div>
            </form>

            <div class="card border-0 shadow-sm">
                <div class="mt-3">
                    {{ $tire_sizes->links() }}
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4">ไซส์ยาง</th>
                                <th>องค์ประกอบ (W / S / R)</th>
                                <th>จำนวนสินค้าในระบบ</th>
                                <th class="text-end pe-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tire_sizes as $size)
                                <tr>
                                    <td class="ps-4">
                                        <span
                                            class="spec-badge">{{ $size->size ?? $size->width . '/' . $size->ratio . ' R' . $size->rim }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="dim-box">
                                                <div class="dim-label">Width</div>
                                                <div class="dim-value">{{ $size->width }}</div>
                                            </div>
                                            <div class="dim-box">
                                                <div class="dim-label">Series</div>
                                                <div class="dim-value">{{ $size->ratio }}</div>
                                            </div>
                                            <div class="dim-box">
                                                <div class="dim-label">Rim</div>
                                                <div class="dim-value">{{ $size->rim }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold text-danger">
                                                {{ $size->products_count ?? 0 }} SKU
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteTireSizeModal{{ $size->id }}"><i
                                                class="fa-solid bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <div class="modal fade" data-bs-backdrop="static"
                                    id="deleteTireSizeModal{{ $size->id }}" tabindex="-1">
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
                                                <a href="{{ url('admin/products/delete-tire-size') }}/{{ $size->id }}"
                                                    class="btn btn-danger">ยืนยันลบข้อมูล</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-magnifying-glass mb-2"></i><br>
                                        ไม่พบข้อมูลไซส์ยางที่ค้นหา
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $tire_sizes->links() }}
                </div>
            </div>
        </div>

        <div class="modal fade" data-bs-backdrop="static" id="addSizeModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ url('admin/products/create-tire-size') }}"
                        enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">เพิ่มขนาดใหม่</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-light border small text-muted">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                กรุณาตรวจสอบว่ายังไม่มีไซส์นี้ในระบบ เพื่อป้องกันข้อมูลซ้ำซ้อน
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <label class="form-label fw-bold small">หน้ากว้าง</label>
                                    <input type="text" id="width" name="width" class="form-control text-center"
                                        placeholder="เช่น 185" oninput="updatePreview()">
                                </div>
                                <div class="col-4">
                                    <label class="form-label fw-bold small">ซีรีส์/แก้มยาง</label>
                                    <input type="text" id="ratio" name="ratio" class="form-control text-center"
                                        placeholder="เช่น 60" oninput="updatePreview()">
                                </div>
                                <div class="col-4">
                                    <label class="form-label fw-bold small">ขอบล้อ</label>
                                    <input type="text" id="rim" name="rim" class="form-control text-center"
                                        placeholder="เช่น R15" oninput="updatePreview()">
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <div class="small text-muted mb-2">ตัวอย่างการแสดงผล</div>
                                <span class="spec-badge" id="preview-text">---/-- --</span>
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
        function updatePreview() {
            let w = document.getElementById('width').value;
            let r = document.getElementById('ratio').value;
            let rim = document.getElementById('rim').value;

            w = w ? w : '---';
            r = r ? r : '--';
            rim = rim ? rim : '--';

            if (rim !== '--' && !rim.toUpperCase().includes('R')) {
                rim = rim;
            }

            document.getElementById('preview-text').innerText = `${w}/${r} ${rim}`;
        }
    </script>
@endsection
