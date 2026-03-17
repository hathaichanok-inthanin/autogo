@extends('frontend/layouts/template')

@section('content')
    <div class="container">
        @if (session('alert-success'))
            <div class="alert alert-success mt-5">
                {{ session('alert-success') }}
            </div>
        @endif
        <h2 class="display-5 fw-bold text-center text-blue mt-5 mb-3">ติดต่อเรา</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <h4><i class="fas fa-map-marker-alt"></i> AUTOGO</h4>
                    <h6>4/51 หมู่ 1 ตำบลโคกกลอย อำเภอตะกั่วทุ่ง จังหวัดพังงา 82140</h6>
                    <h5 class="mt-3"><i class="fas fa-phone"></i> 096-634-1673</h5>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d493.5341175012806!2d98.3036066002906!3d8.275609982832297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30505a798d81071f%3A0x8886f4b8cdeb0c9d!2z4LmE4LiX4Lij4LmM4Lie4Lil4Lix4LiqIOC4nuC4seC4h-C4h-C4siBCeSDguYDguK3guIHguIHguLLguKPguKLguLLguIcg4Liq4Liy4LiC4Liy4LmC4LiE4LiB4LiB4Lil4Lit4Lii!5e0!3m2!1sth!2sth!4v1770260977615!5m2!1sth!2sth"
                        width="100%" height="310" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <div class="card-body">
                        <form method="POST" action="{{ route('contact-us-post') }}">@csrf
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="contact-form form-floating">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="ชื่อ-นามสกุล">
                                        <label>ชื่อ-นามสกุล</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-form form-floating">
                                        <input type="text" name="tel" class="form-control"
                                            placeholder="เบอร์โทรศัพท์">
                                        <label>เบอร์โทรศัพท์</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="contact-form">
                                        <select name="shop_id" class="form-control">
                                            <option value="" selected disabled>เลือกสาขาที่ใช้บริการ</option>
                                            @foreach ($shops as $shop => $value)
                                                <option value="{{ $value->id }}">{{ $value->shop_name }}
                                                    {{ $value->branch_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="contact-form form-floating">
                                        <textarea name="comment" cols="30" style="height: 150px; resize: none;" class="form-control"
                                            placeholder="รายละเอียด"></textarea>
                                        <label>รายละเอียด</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn-search mt-3">ยืนยันข้อมูล</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
