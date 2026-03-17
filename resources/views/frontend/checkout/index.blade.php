@extends('frontend/layouts/template')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container py-5 mb-5">
        <h2 class="mb-4">สรุปรายการและนัดหมายติดตั้ง</h2>

        <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="row mt-4">

                {{-- ฝั่งซ้าย: ข้อมูลลูกค้า + เลือกสาขา --}}
                <div class="col-md-8">

                    {{-- 1. ข้อมูลผู้ติดต่อ --}}
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-blue text-center">
                                <tr>
                                    <th width="100">รูปภาพ</th>
                                    <th>สินค้า</th>
                                    <th width="100">ราคา</th>
                                    <th width="120">จำนวน</th>
                                    <th width="100">รวม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('cart') as $id => $details)
                                    <tr>
                                        <td class="text-center">
                                            @if ($details['image'])
                                                <img src="{{ asset('/image_upload/model_image/' . $details['image']) }}"
                                                    width="60" class="img-thumbnail">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" width="60">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $details['name'] }}</div>
                                        </td>
                                        <td class="text-end">{{ number_format($details['price']) }}</td>
                                        <td class="text-center">
                                            <div class="input-group" style="min-width: 100px; width: 100px; height: 50px;">
                                                <input type="text"
                                                    class="form-control form-control-sm text-center h-100 qty-input p-0 update-cart"
                                                    data-id="{{ $id }}" readonly style="font-size: 16px;"
                                                    value="{{ $details['quantity'] }}">
                                            </div>
                                        </td>

                                        <td class="text-end fw-bold subtotal-{{ $id }}">
                                            {{ number_format($details['price'] * $details['quantity']) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">นัดหมายติดตั้ง</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ $shop_name }} {{ $branch_name }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control"
                                        value="วันที่ {{ $bookingDate }} เวลา {{ $bookingTime }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">ข้อมูลลูกค้า</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>ชื่อ-นามสกุล : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mt-3" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label>เบอร์โทรศัพท์ : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mt-3" name="tel" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">ข้อมูลรถ</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>ยี่ห้อรถ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mt-3" name="car_brand"
                                        placeholder="เช่น Honda" required>
                                </div>
                                <div class="col-md-4">
                                    <label>รุ่นรถ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mt-3" name="car_model"
                                        placeholder="เช่น Civic" required>
                                </div>
                                <div class="col-md-4">
                                    <label>ทะเบียนรถ<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mt-3" name="license_plate"
                                        placeholder="เช่น 1กข-9999" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ฝั่งขวา: สรุปยอดเงิน --}}
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-blue">
                            <h5 class="mb-0 text-white">สรุปคำสั่งซื้อ</h5>
                        </div>
                        <div class="card-body">
                            {{-- วนลูปแสดงสินค้าในตะกร้า --}}
                            @php $total = 0; @endphp
                            @if ($cart)
                                @foreach ($cart as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <small class="font-weight-bold">{{ $details['name'] }}</small><br>
                                            <small class="text-muted">x {{ $details['quantity'] }}</small>
                                        </div>
                                        <span>{{ number_format($details['price'] * $details['quantity']) }}</span>
                                    </div>
                                @endforeach
                            @endif

                            <hr>
                            <div class="d-flex justify-content-between">
                                <h5>ยอดรวมสุทธิ</h5>
                                <h5 class="text-danger">{{ number_format($total) }} บาท</h5>
                            </div>


                            <input type="hidden" name="booking_date" value="{{ session('booking_date') }}">
                            <input type="hidden" name="booking_time" value="{{ session('booking_time') }}">
                            <input type="hidden" name="branch_id" value="{{ session('selected_branch_id') }}">
                            {{-- <input type="hidden" name="tel" value="{{ $user->tel }}"> --}}

                            <button type="submit" class="btn btn-warning btn-block btn-lg mt-3 text-danger">
                                ยืนยันคำสั่งซื้อ
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

@endsection
