@extends('backend/layouts/template-auth')

@section('content')
    <div class="container">
        <h1 class="mt-5 text-center"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบแอดมินหลัก</h1>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.login.submit') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <input type="text" class="form-control" name="username"
                                        placeholder="ชื่อเข้าใช้งาน">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="password" class="form-control" name="password"
                                        placeholder="รหัสผ่าน">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn-search btn-block mt-5">เข้าสู่ระบบ</button>
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
