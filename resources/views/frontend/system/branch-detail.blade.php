@extends('frontend/layouts/template')

@section('content')
    @php
        $lat = $branch->latitude;
        $lng = $branch->longitude;

        use Carbon\Carbon;
        $open_time = Carbon::parse($branch->open_time)->format('H:i');
        $close_time = Carbon::parse($branch->close_time)->format('H:i');
    @endphp
    <div class="container">
        <h1 class="mt-5">{{ $branch->shop_name }} {{ $branch->branch_name }}</h1>
        <hr>
        <div class="row mt-3">
            <div class="col-md-6">
                <img src="{{ asset('/image_upload/shop_image') }}/{{ $branch->shop_image }}" width="100%"
                    class="img-responsive">
            </div>
            <div class="col-md-6">
                <p><strong>ที่อยู่ : </strong>{{ $branch->address_text }} ตำบล{{ $branch->subdistrict }}
                    อำเภอ{{ $branch->district }}
                    จังหวัด{{ $branch->province }} {{ $branch->zipcode }}</p>
                <p><strong>เบอร์โทรศัพท์ : </strong>{{ $branch->phone }}</p>
                <p><strong>เวลาทำการ : </strong>{{ $open_time }} น. -
                    {{ $close_time }} น.</p>
                <div class="mt-3 mb-3">
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <a href="{{ url('/branch/select') }}/{{ $branch->id }}"
                                class="btn-search btn-block text-center">เลือกสาขาสำหรับติดตั้ง</a>
                        </div>
                        <div class="col-md-6 mt-3">
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $lat }},{{ $lng }}"
                                target="_blank" class="btn-search btn-block fw-bold">
                                ดู Google Map
                            </a>
                        </div>

                        <div class="mt-5">
                            <iframe width="100%" height="240" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&hl=th&z=17&output=embed">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
