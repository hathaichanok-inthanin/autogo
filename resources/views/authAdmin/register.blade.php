@extends('backend/layouts/template-auth')

@section('content')
    <div class="container">
        <h1 class="mt-5 text-center"><i class="fas fa-pen-square"></i> ลงทะเบียนแอดมินดูแลระบบหลัก</h1>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <form method="POST" action="{{ url('admin/register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <input type="text" class="form-control" name="name" placeholder="ชื่อ *">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="text" class="form-control" name="surname" placeholder="นามสกุล *">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="text" class="form-control" name="phone" placeholder="เบอร์โทรศัพท์ *">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <select name="role" class="form-select">
                                        <option value="ผู้ดูแลระบบหลัก">ผู้ดูแลระบบหลัก</option>
                                        <option value="ผู้แก้ไข">ผู้แก้ไข</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="text" class="form-control" name="username"
                                        placeholder="ชื่อเข้าใช้งาน *">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="password" class="form-control" name="password_name"
                                        placeholder="รหัสผ่าน *">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="password" class="form-control" name="password_confirmation"
                                        placeholder="ยืนยันรหัสผ่านอีกครั้ง *">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <select name="status" class="form-select">
                                        <option value="เปิดใช้งาน">เปิดใช้งาน</option>
                                        <option value="ปิดการใช้งาน">ปิดการใช้งาน</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn-search btn-block mt-5">ยืนยันข้อมูลการลงทะเบียน</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <img src="{{ asset('frontend/assets/image/logo.png') }}" alt="logo"
            class="img-responsive mt-5 d-block mx-auto" width="50%">
    </div>
@endsection
