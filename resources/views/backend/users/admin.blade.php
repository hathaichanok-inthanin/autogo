@extends('backend/layouts/template')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">จัดการผู้ดูแลระบบ</h4>
            </div>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                <i class="fa-solid fa-user-shield me-1"></i> เพิ่มผู้ดูแลใหม่
            </button>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="mt-3">
                {{ $account_admins->links() }}
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th>ผู้ดูแลระบบ</th>
                            <th>สิทธิ์การใช้งาน</th>
                            <th>ใช้งานล่าสุด</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($account_admins as $account_admin => $value)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $value->name }}</div>
                                            <div class="small text-muted">{{ $value->username }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="role-badge role-super">
                                        <i class="fa-solid fa-crown"></i> {{ $value->role }}
                                    </span>
                                    @if ($value->role == 'Super Admin')
                                        <div class="small text-muted">เข้าถึงได้ทุกเมนู</div>
                                    @elseif($value->role == 'Admin')
                                        <div class="small text-muted">เข้าถึงได้ทุกเมนู
                                            ยกเว้นการเงินและการตั้งค่าระบบ</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($value->isOnline())
                                        <span class="badge rounded-pill bg-success">
                                            <i class="fa-solid fa-circle fa-2xs"></i> Online
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">
                                            Offline
                                        </span>
                                        <small class="text-muted">
                                            (ใช้งานล่าสุด
                                            {{ $value->last_active_at ? $value->last_active_at->diffForHumans() : 'ไม่เคยใช้งาน' }})
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if ($value->status == 'เปิดใช้งาน')
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success">{{ $value->status }}</span>
                                    @elseif($value->status == 'ระงับใช้งาน')
                                        <span
                                            class="badge bg-danger bg-opacity-10 text-danger border border-danger">{{ $value->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-light text-primary me-1" data-bs-toggle="modal"
                                        data-bs-target="#editAdminModal{{ $value->id }}"><i
                                            class="fa-solid bi bi-pen"></i></button>
                                    <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteAdminModal{{ $value->id }}"><i
                                            class="fa-solid bi bi-trash"></i></button>
                                </td>
                            </tr>
                            {{-- Add Admin --}}
                            <div class="modal fade" data-bs-backdrop="static" id="addAdminModal" data-bs-backdrop="static"
                                tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ url('admin/register') }}"
                                            enctype="multipart/form-data">@csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-plus me-2"></i>
                                                    เพิ่มผู้ดูแลระบบใหม่
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">ชื่อ-นามสกุล</label>
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="เช่น ใจดี มีน้ำใจ">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">ชื่อผู้ใช้งาน (สำหรับ Login)</label>
                                                    <input type="text" name="username" class="form-control"
                                                        placeholder="เช่น Jaidee">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">กำหนดบทบาท (Role)</label>
                                                    <div class="list-group">
                                                        <label class="list-group-item d-flex gap-2">
                                                            <input class="form-check-input flex-shrink-0" type="radio"
                                                                name="role" value="Super Admin">
                                                            <span>
                                                                <strong>Super Admin (ผู้ดูแลระบบหลัก)</strong>
                                                                <small class="d-block text-muted">เข้าถึงได้ทุกเมนู</small>
                                                            </span>
                                                        </label>
                                                        <label class="list-group-item d-flex gap-2">
                                                            <input class="form-check-input flex-shrink-0" type="radio"
                                                                name="role" value="Admin" checked>
                                                            <span>
                                                                <strong>Admin (ผู้ดูแลระบบ)</strong>
                                                                <small class="d-block text-muted">เข้าถึงได้ทุกเมนู
                                                                    ยกเว้นการเงินและการตั้งค่าระบบ</small>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">รหัสผ่านชั่วคราว</label>
                                                    <div class="input-group">
                                                        <input type="text" name="password_name" class="form-control"
                                                            value="TireMk@2025" id="tempPass">

                                                        <button class="btn btn-outline-primary" type="button"
                                                            onclick="generatePassword()" title="สุ่มรหัสผ่านใหม่"> Gen Code
                                                        </button>

                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="btnCopy" onclick="copyToClipboard()">
                                                            <i class="fa-solid fa-copy"></i> Copy
                                                        </button>
                                                    </div>
                                                    <div class="form-text">กดปุ่ม Gen Code เพื่อสุ่มรหัสผ่านใหม่
                                                        หรือแก้ไขเองได้</div>
                                                </div>
                                                <input type="hidden" name="status" value="เปิดใช้งาน">
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit"
                                                    class="btn btn-warning fw-bold px-4">สร้างบัญชี</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Edit Admin --}}
                            <div class="modal fade" data-bs-backdrop="static" id="editAdminModal{{ $value->id }}"
                                data-bs-backdrop="static" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ url('admin/users/edit-account-admin') }}"
                                            enctype="multipart/form-data">@csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-plus me-2"></i>
                                                    แก้ไขผู้ดูแลระบบใหม่
                                                </h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">ชื่อ-นามสกุล</label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ $value->name }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">ชื่อผู้ใช้งาน (สำหรับ Login)</label>
                                                    <input type="text" name="username" class="form-control"
                                                        value="{{ $value->username }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">กำหนดบทบาท (Role)</label>
                                                    <div class="list-group">
                                                        <label class="list-group-item d-flex gap-2">
                                                            <input class="form-check-input flex-shrink-0" type="radio"
                                                                name="role" value="Super Admin"
                                                                {{ old('role', $value->role) == 'Super Admin' ? 'checked' : '' }}>
                                                            <span>
                                                                <strong>Super Admin (ผู้ดูแลระบบหลัก)</strong>
                                                                <small class="d-block text-muted">เข้าถึงได้ทุกเมนู</small>
                                                            </span>
                                                        </label>
                                                        <label class="list-group-item d-flex gap-2">
                                                            <input class="form-check-input flex-shrink-0" type="radio"
                                                                name="role" value="Admin"
                                                                {{ old('role', $value->role) == 'Admin' ? 'checked' : '' }}>
                                                            <span>
                                                                <strong>Admin (ผู้ดูแลระบบ)</strong>
                                                                <small class="d-block text-muted">เข้าถึงได้ทุกเมนู
                                                                    ยกเว้นการเงินและการตั้งค่าระบบ</small>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">สถานะ</label>
                                                    <select name="status" class="form-control">
                                                        <option value="เปิดใช้งาน"
                                                            {{ $value->status == 'เปิดใช้งาน' ? 'selected' : '' }}>
                                                            เปิดใช้งาน
                                                        </option>
                                                        <option value="ระงับใช้งาน"
                                                            {{ $value->status == 'ระงับใช้งาน' ? 'selected' : '' }}>
                                                            ระงับใช้งาน
                                                        </option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="id" value="{{ $value->id }}">

                                            </div>
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
                            <div class="modal fade" data-bs-backdrop="static" id="deleteAdminModal{{ $value->id }}"
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
                                            <a href="{{ url('admin/users/delete-account-admin') }}/{{ $value->id }}"
                                                class="btn btn-danger">ยืนยันลบข้อมูล</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $account_admins->links() }}
            </div>
        </div>
    </div>

    <script>
        function generatePassword() {
            var length = 12;
            var charset = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789@#$";
            var retVal = "";

            for (var i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }

            var inputField = document.getElementById("tempPass");
            inputField.value = retVal;

            inputField.style.backgroundColor = "#e8f0fe";
            setTimeout(() => {
                inputField.style.backgroundColor = "white";
            }, 300);
        }

        function copyToClipboard() {
            var copyText = document.getElementById("tempPass");
            var copyBtn = document.getElementById("btnCopy");

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copyText.value).then(() => {

                var originalHtml = copyBtn.innerHTML;

                copyBtn.classList.remove('btn-outline-secondary');
                copyBtn.classList.add('btn-success');
                copyBtn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';

                setTimeout(function() {
                    copyBtn.classList.remove('btn-success');
                    copyBtn.classList.add('btn-outline-secondary');
                    copyBtn.innerHTML = originalHtml;
                }, 2000);
            });
        }
    </script>
@endsection
