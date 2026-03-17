@extends('backend/layouts/template')

@section('content')
    <div class="app-content">


        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-1">บัญชีผู้ใช้ร้านค้า</h4>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addShopUserModal">
                    <i class="fa-solid fa-user-plus me-1"></i> เพิ่มผู้ใช้ใหม่
                </button>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="mt-3">
                    {{ $partners->links() }}
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4">ร้านค้า</th>
                                <th>บัญชีผู้ใช้</th>
                                <th>รหัสผ่าน</th>
                                <th>สถานะ</th>
                                <th class="text-end pe-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partners as $partner)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $partner->shop->shop_name ?? '-' }}</div>
                                        <div class="text-muted">{{ $partner->shop->branch_name ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $partner->name }}</div>
                                                <div class="small text-muted">{{ $partner->tel }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="password" id="passwordInput" class="form-control"
                                                value="{{ $partner->password_name }}">

                                            <span class="input-group-text" style="cursor: pointer;"
                                                onclick="togglePassword()">
                                                <i class="bi bi-eye" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column">
                                            @if ($partner->status)
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
                                        <a href="{{ url('admin/users/staffs') }}/{{ $partner->id }}"
                                            class="btn btn-sm btn-light text-success">บัญชีพนักงาน</a>
                                        <button class="btn btn-sm btn-light text-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#editUser{{ $partner->id }}"><i
                                                class="fa-solid bi bi-pen"></i></button>
                                        <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteUser{{ $partner->id }}"><i
                                                class="fa-solid bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                {{-- delete --}}
                                <div class="modal fade" data-bs-backdrop="static" id="deleteUser{{ $partner->id }}"
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
                                                <form
                                                    action="{{ url('admin/users/delete-account-partner/' . $partner->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">ยืนยันลบข้อมูล</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Edit --}}
                                <div class="modal fade" data-bs-backdrop="static" id="editUser{{ $partner->id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form method="POST" action="{{ url('admin/users/edit-account-partner') }}">@csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">แก้ไขบัญชีผู้ใช้ร้านค้า</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">1. ร้านค้า<span
                                                                class="text-danger">*</span></label>
                                                        <select name="shop_id" class="form-select bg-light">
                                                            <option selected disabled>-- ค้นหาร้านค้า --</option>
                                                            @foreach ($shops as $shop)
                                                                <option value="{{ $shop->id }}"
                                                                    {{ $partner->shop_id == $shop->id ? 'selected' : '' }}>
                                                                    {{ $shop->shop_name }} {{ $shop->branch_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <hr>

                                                    <div class="row g-2 mb-3">
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">2. บัญชีผู้ใช้งาน</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label small">ชื่อผู้ใช้งาน</label>
                                                            <input name="name" type="text" class="form-control"
                                                                value="{{ $partner->name }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label small">เบอร์โทร (Username)</label>
                                                            <input name="tel" type="text" class="form-control"
                                                                value="{{ $partner->tel }}">
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="mb-3">
                                                        <label class="form-label">สถานะ</label>
                                                        <select name="status" class="form-control">
                                                            <option value="เปิดใช้งาน"
                                                                {{ $partner->status == 'เปิดใช้งาน' ? 'selected' : '' }}>
                                                                เปิดใช้งาน
                                                            </option>
                                                            <option value="ปิดใช้งาน"
                                                                {{ $partner->status == 'ปิดใช้งาน' ? 'selected' : '' }}>
                                                                ปิดใช้งาน
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">ยกเลิก</button>
                                                    <input type="hidden" name="id" value="{{ $partner->id }}">
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
                <div class="mt-3">
                    {{ $partners->links() }}
                </div>
            </div>
        </div>

        <div class="modal fade" data-bs-backdrop="static" id="addShopUserModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form method="POST" action="{{ url('admin/users/add-partner') }}">@csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">เพิ่มบัญชีผู้ใช้ร้านค้า</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">1. ร้านค้า<span class="text-danger">*</span></label>
                                <select name="shop_id" class="form-select bg-light">
                                    <option selected disabled>-- ค้นหาร้านค้า --</option>
                                    @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}">{{ $shop->shop_name }}
                                            {{ $shop->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>

                            <div class="row g-2 mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">2. บัญชีผู้ใช้งาน</label>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small">ชื่อ-นามสกุล</label>
                                    <input name="name" type="text" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small">เบอร์โทร (Username)</label>
                                    <input name="tel" type="text" class="form-control">
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">3. ตั้งรหัสผ่าน</label>
                                <div class="input-group">
                                    <input type="text" name="password_name" class="form-control" value="TireMk@2025"
                                        id="tempPass">

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
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-warning fw-bold px-4">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
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
        function togglePassword() {
            const passwordInput = document.getElementById("passwordInput");
            const toggleIcon = document.querySelector(".toggle-password");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.style.opacity = "0.5";
            } else {
                passwordInput.type = "password";
                toggleIcon.style.opacity = "1";
            }
        }
    </script>
@endsection
