@extends('backend/layouts/template')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-1">บัญชีพนักงาน</h4>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="fa-solid fa-user-plus me-1"></i> เพิ่มพนักงานใหม่
            </button>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4">ร้านค้า</th>
                            <th>บัญชีผู้ใช้</th>
                            <th>ชื่อเข้าใช้งาน</th>
                            <th>รหัสผ่าน</th>
                            <th>สถานะ</th>
                            <th class="text-end pe-4">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $staff => $value)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $value->partner->shop->shop_name }}</div>
                                    <div class="text-muted">{{ $value->partner->shop->branch_name }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $value->name }}</div>
                                            <div class="small text-muted">{{ $value->tel }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $value->username }}</div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="password" id="passwordInput_{{ $value->id }}" class="form-control"
                                            value="{{ $value->password_name }}">

                                        <span class="input-group-text" style="cursor: pointer;"
                                            onclick="togglePassword('{{ $value->id }}')">
                                            <i class="bi bi-eye" id="toggleIcon_{{ $value->id }}"></i>
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column">
                                        @if ($value->status)
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
                                    <button class="btn btn-sm btn-light text-primary me-1" data-bs-toggle="modal"
                                        data-bs-target="#editStaff{{ $value->id }}"><i
                                            class="fa-solid bi bi-pen"></i></button>
                                    <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteStaff{{ $value->id }}"><i
                                            class="fa-solid bi bi-trash"></i></button>
                                </td>
                            </tr>
                            {{-- delete --}}
                            <div class="modal fade" data-bs-backdrop="static" id="deleteStaff{{ $value->id }}" tabindex="-1">
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
                                            <form action="{{ url('admin/users/delete-account-staff/' . $value->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">ยืนยันลบข้อมูล</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Edit --}}
                            <div class="modal fade" data-bs-backdrop="static" id="editStaff{{ $value->id }}"
                                tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form method="POST" action="{{ url('admin/users/edit-account-staff') }}">@csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">แก้ไขบัญชีพนักงาน</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row g-2 mb-3">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">ข้อมูลบัญชีผู้ใช้</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label small">ชื่อ-นามสกุล</label>
                                                        <input name="name" type="text" class="form-control"
                                                            value="{{ $value->name }}">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label small">username (ชื่อเข้าใช้งาน ภาษาอังกฤษ)</label>
                                                        <input name="username" type="text" class="form-control"
                                                            value="{{ $value->username }}">
                                                    </div>
                                                </div>

                                                <hr>

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
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">ยกเลิก</button>
                                                <input type="hidden" name="id" value="{{ $value->id }}">
                                                <button type="submit"
                                                    class="btn btn-warning fw-bold px-4">บันทึก</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" id="addStaffModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ url('admin/users/add-staff') }}">@csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">เพิ่มบัญชีพนักงาน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2 mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">บัญชีผู้ใช้งาน</label>
                            </div>
                            <div class="col-12">
                                <label class="form-label small">ชื่อ-นามสกุล</label>
                                <input name="name" type="text" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label small">username (ชื่อเข้าใช้งาน ภาษาอังกฤษ)</label>
                                <input name="username" type="text" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label fw-bold">ตั้งรหัสผ่าน</label>
                            <div class="input-group">
                                <input type="text" name="password_name" class="form-control" id="tempPass">

                                <button class="btn btn-outline-primary" type="button" onclick="generatePassword()"
                                    title="สุ่มรหัสผ่านใหม่"> Gen Code
                                </button>

                                <button class="btn btn-outline-secondary" type="button" id="btnCopy"
                                    onclick="copyToClipboard()">
                                    <i class="fa-solid fa-copy"></i> Copy
                                </button>
                            </div>
                            <div class="form-text small">กดปุ่ม Gen Code เพื่อสุ่มรหัสผ่านใหม่
                                หรือแก้ไขเองได้</div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <input type="hidden" name="partner_id" value="{{ $partner_id }}">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-warning fw-bold px-4">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        // ฟังก์ชันสุ่มรหัสผ่าน
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
    <script>
        function togglePassword(id) {
            const inputField = document.getElementById('passwordInput_' + id);
            const icon = document.getElementById('toggleIcon_' + id);

            if (inputField.type === "password") {
                inputField.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                inputField.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }
    </script>
@endsection
