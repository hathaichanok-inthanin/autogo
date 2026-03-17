@extends('frontend/layouts/template')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@section('content')
    <div class="container">
        <h1 class="mt-5"><i class="fas fa-pen-square"></i> ลงทะเบียนลูกค้าใหม่</h1>
        <p>ลงทะเบียนสมาชิกใหม่ เพื่อรับข้อมูลข่าวสารและสิทธิพิเศษก่อนใคร</p>
        <div class="card mt-5">
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">

                        <div class="col-md-4 mt-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="ชื่อ *" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mt-3">
                            <input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname"
                                placeholder="นามสกุล *" value="{{ old('surname') }}">
                            @error('surname')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mt-3">
                            <input type="text" class="form-control" name="bday" id="bday_picker"
                                placeholder="วัน/เดือน/ปีเกิด (เช่น 31/01/1990)" value="{{ old('bday') }}">
                            @error('bday')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mt-3">
                            <input type="tel" class="form-control @error('tel') is-invalid @enderror" name="tel"
                                placeholder="เบอร์โทรศัพท์ *" value="{{ old('tel') }}">
                            @error('tel')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                                placeholder="ที่อยู่ *" value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="text" class="form-control @error('subdistrict') is-invalid @enderror"
                                name="subdistrict" id="subdistrict" placeholder="ตำบล / แขวง *"
                                value="{{ old('subdistrict') }}">
                            @error('subdistrict')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="text" class="form-control @error('district') is-invalid @enderror"
                                name="district" id="district" placeholder="อำเภอ / เขต *" value="{{ old('district') }}">
                            @error('district')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="text" class="form-control @error('province') is-invalid @enderror"
                                name="province" id="province" placeholder="จังหวัด *" value="{{ old('province') }}">
                            @error('province')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode"
                                id="zipcode" placeholder="รหัสไปรษณีย์ *" value="{{ old('zipcode') }}">
                            @error('zipcode')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <hr class="mt-5 mb-5">
                        </div>

                        <div class="col-md-4 mt-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                placeholder="อีเมล (ใช้เป็นชื่อเข้าใช้งาน) *" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mt-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="รหัสผ่าน">
                            @error('password')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mt-3">
                            <input type="password" class="form-control" name="password_confirmation"
                                placeholder="ยืนยันรหัสผ่าน">
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn-search btn-block mt-5">ยืนยันข้อมูลการลงทะเบียน</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    {{-- ที่อยู่ --}}
    <script type="text/javascript"
        src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
    <script type="text/javascript"
        src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
    <link rel="stylesheet"
        href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <script type="text/javascript"
        src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>

    <script>
        flatpickr("#bday_picker", {
            dateFormat: "d/m/Y",
            locale: "th",
            disableMobile: "true"
        });
    </script>

    <script>
        // เรียกใช้ JQuery Thailand
        $.Thailand({
            $district: $('#subdistrict'),
            $amphoe: $('#district'),
            $province: $('#province'),
            $zipcode: $('#zipcode'),

            onDataFill: function(data) {
                console.log(data);
            }
        });
    </script>
@endsection
