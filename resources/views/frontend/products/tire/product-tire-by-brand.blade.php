@extends('frontend/layouts/template')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <h1 class="text-blue">ยางรถยนต์ {{ $brand }}</h1>
        </div>
        <div class="row">
            @foreach ($models as $model => $value)
                <div class="col-md-3 col-6">
                    <img src="{{ url('image_upload/model_image') }}/{{ $value->model_image }}" alt="{{ $value->model_image }}"
                        width="100%">
                    <h4 class="text-blue text-center">{{ $value->model_name }}</h4>
                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{url('product/tire/model/')}}/{{$brand}}/{{$value->model_name}}" class="btn-search text-center">ดูสินค้าเพิ่มเติม</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
