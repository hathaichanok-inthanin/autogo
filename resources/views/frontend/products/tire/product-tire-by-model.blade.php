@extends('frontend/layouts/template')
<style>
    .product-card {
        border: 1px solid #eee;
        border-radius: 8px;
        background: #fff;
        padding: 10px;
        position: relative;
        transition: all 0.3s;
    }

    .product-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
        text-align: center;
        font-size: 16px;
        margin-right: 9px;
        color: #333;
        display: inline-block;
        width: 100px;
        vertical-align: top;
        font-weight: bold;
    }

    .feature-icon i {
        font-size: 25px;
        margin-bottom: 5px;
        display: block;
    }

    .brand-logo-responsive {
        width: 40%;
    }


    /* mobile */
    @media (min-width: 768px) {
        .brand-logo-responsive {
            width: 20%;
        }
    }
</style>
@section('content')
    @php
        $carbonDate = Carbon\Carbon::now()->endOfMonth();
        $carbonDate->locale('th');
        $date_format = $carbonDate->isoFormat('D MMMM') . ' ' . ($carbonDate->year + 543);
    @endphp
    <div class="container py-4">
        <h1 class="mt-5 text-blue">ยาง {{$brand}} {{$model}}</h1>
        @foreach ($products as $product)
            @php
                $price_normal = $product->price; // ราคาเต็ม
                $price_sale = $product->sale_price; // ราคาลด (ถ้ามี)

                $feature = DB::table('tire_specs')->where('product_id', $product->id)->value('features');

                $features = json_decode($feature ?? '[]', true);

                $featureMap = [
                    'Silent' => ['img' => 'frontend/assets/image/feature/silent.png', 'text' => 'นุ่มเงียบ'],
                    'Sport' => ['img' => 'frontend/assets/image/feature/silent.png', 'text' => 'สปอร์ต/เกาะถนน'],
                    'Save' => ['img' => 'frontend/assets/image/feature/silent.png', 'text' => 'ประหยัดน้ำมัน'],
                    'Wet' => ['img' => 'frontend/assets/image/feature/silent.png', 'text' => 'เบรกสั้น'],
                    'Offroad' => ['img' => 'frontend/assets/image/feature/silent.png', 'text' => 'Off-road'],
                ];
            @endphp
            <div class="product-card mb-3 mt-5">
                <div class="row align-items-center">

                    <div class="col-md-2 text-center position-relative">
                        <img src="{{ asset('/image_upload/model_image') }}/{{ $product->tireSpec->model->model_image }}"
                            class="img-fluid" style="max-width: 80% !important;">
                    </div>

                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <img src="{{ asset('/image_upload/brand_image') }}/{{ $product->tireSpec->brand->brand_image }}"
                                        class="img-fluid brand-logo-responsive">
                                </div>

                                <h2 class="fw-bold">
                                    {{ $product->tireSpec->width }}/{{ $product->tireSpec->ratio }}R{{ $product->tireSpec->rim }}
                                    {{ $product->tireSpec->model->model_name }}</h2>

                                <div class="d-flex flex-wrap mt-3 mb-3">
                                    @if (is_array($features) && count($features) > 0)
                                        @foreach ($features as $key)
                                            @if (isset($featureMap[$key]))
                                                <div class="feature-icon">
                                                    <img src="{{ asset($featureMap[$key]['img']) }}" alt="{{ $featureMap[$key]['text'] }}"><br>
                                                    {{ $featureMap[$key]['text'] }}
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 border-start">
                                <div class="p-2">
                                    @if ($price_sale > 0 && $price_sale < $price_normal)
                                        {{-- กรณีมีราคาโปรโมชั่น --}}
                                        <h3 class="price-old">ราคาปกติ <del>{{ number_format($price_normal) }}</del> บาท
                                        </h3>
                                        <h1 class="price-promo text-danger">฿ {{ number_format($price_sale) }}
                                            บาท
                                        </h1>
                                    @else
                                        {{-- กรณีราคาปกติ --}}
                                        <h1 class="price-promo text-danger">฿ {{ number_format($price_normal) }}
                                            บาท
                                        </h1>
                                    @endif

                                    <small class="text-danger d-block mb-3">ราคามีผลถึงวันที่ {{ $date_format }}</small>

                                    <div class="d-flex flex-nowrap gap-2 mt-2">

                                        <div class="input-group" style="min-width: 100px; width: 100px; height: 50px;">
                                            <button class="btn btn-warning btn-sm h-100 btn-minus p-0" type="button"
                                                style="font-size: 20px; width: 30px;">-</button>

                                            <input type="text"
                                                class="form-control form-control-sm text-center h-100 qty-input p-0"
                                                value="1" readonly style="font-size: 16px;">

                                            <button class="btn btn-warning btn-sm h-100 btn-plus p-0" type="button"
                                                style="font-size: 20px; width: 30px;">+</button>
                                        </div>

                                        <button class="btn-search flex-grow-1 text-nowrap p-0 btn-add-to-cart"
                                            data-id="{{ $product->id }}" type="button"
                                            style="height: 50px; display: flex; align-items: center; justify-content: center;">

                                            <i class="bi bi-cart-plus" style="font-size: 1.2rem;"></i>
                                            <span class="ms-2">ใส่ตะกร้า</span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" data-bs-backdrop="static" id="addToCartModal" tabindex="-1"
                aria-labelledby="addToCartModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title text-center text-danger" id="addToCartModalLabel">
                                เพิ่มสินค้าลงในตะกร้าเรียบร้อย
                            </h5>
                            <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <i class="bi bi-cart3 me-2" style="font-size:5rem;"></i>
                        </div>
                        <div class="modal-footer justify-content-center border-0 pb-4">
                            <a href="{{ route('home') }}" class="btn btn-outline-dark px-4">
                                เลือกสินค้าเพิ่ม
                            </a>
                            <a href="{{ route('cart.index') }}" class="btn btn-warning px-4 text-danger">
                                ไปยังตะกร้าสินค้า
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const minusBtns = document.querySelectorAll('.btn-minus');
            minusBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    let input = this.parentElement.querySelector('.qty-input');
                    let value = parseInt(input.value);

                    if (value > 1) {
                        input.value = value - 1;
                    }
                });
            });

            const plusBtns = document.querySelectorAll('.btn-plus');
            plusBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    let input = this.parentElement.querySelector('.qty-input');
                    let value = parseInt(input.value);

                    input.value = value + 1;
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-add-to-cart').click(function(e) {
                e.preventDefault();

                let btn = $(this);
                let productId = btn.data('id');
                let qty = btn.closest('.d-flex').find('.qty-input').val();

                let originalHtml = btn.html();
                btn.html('<span class="spinner-border spinner-border-sm"></span> รอ...').prop('disabled',
                    true);

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: productId,
                        qty: qty
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#cart-count').text(response.cart_count);

                            $('#addToCartModal').modal('show');

                        } else {
                            alert('เกิดข้อผิดพลาด: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
                    },
                    complete: function() {
                        btn.html(originalHtml).prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
