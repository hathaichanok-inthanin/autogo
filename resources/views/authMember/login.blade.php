@extends('frontend/layouts/template')

@section('content')
    <div class="container">
        <h1 class="mt-5 text-center" style="font-size:5rem;"><i class="fas fa-user-alt"></i></h1>
        <h1 class="text-center">เข้าสู่ระบบ</h1>

        @if (session('alert-success'))
            <div class="alert alert-success text-center mt-3">
                {{ session('alert-success') }}
            </div>
        @endif
        @if (session('alert-danger'))
            <div class="alert alert-danger text-center mt-3">
                {{ session('alert-danger') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card mt-3">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="อีเมล *" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" placeholder="รหัสผ่าน *">
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            จำการเข้าสู่ระบบ
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn-search btn-block mt-3">เข้าสู่ระบบ</button>
                                </div>

                                <div class="col-md-12 text-center mt-3">
                                    <a href="{{ route('register') }}" class="text-muted">ยังไม่เป็นสมาชิก?
                                        ลงทะเบียนที่นี่</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection
