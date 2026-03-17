@extends('frontend/layouts/template')

@section('content')
    <div class="container">
        <h1 class="mt-5 text-blue">ยางรถยนต์รันแฟลต</h1>
        <hr>
        <div class="row mt-3">
            @foreach ($brands as $brand => $value)
                <div class="col-12 col-md-3 mt-3">
                    <a href="{{url('product/tire-runflat/brand/')}}/{{$value->brand_name}}"
                        class="brand-item d-flex align-items-center justify-content-between p-2 text-decoration-none">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-hand-index-thumb me-2"></i>
                            <span class="fw-bold text-dark text-uppercase small">ยาง {{ $value->brand_name }}</span>
                        </div>
                        <div class="brand-logo-wrapper">
                            <img src="{{ url('image_upload/brand_image') }}/{{ $value->brand_image }}"
                                class="img-fluid">
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
