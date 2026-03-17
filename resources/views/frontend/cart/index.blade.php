@extends('frontend/layouts/template')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@section('content')
    @if (session('error'))
        <div class="alert alert-danger" style="color: red; padding: 20px; border: 1px solid red; margin: 20px 0;">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('cart.proceed') }}" method="POST">
        @csrf
        <div class="container py-5">
            <h2 class="mb-4"><i class="bi bi-cart3 me-2"></i>ตะกร้าสินค้า</h2>
            <hr>
            <h4 class="mb-4">รายการสินค้า</h4>

            @if (session('cart') && count(session('cart')) > 0)
                <div class="row">
                    {{-- ตารางรายการสินค้า --}}
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-blue text-center">
                                    <tr>
                                        <th width="100">รูปภาพ</th>
                                        <th>สินค้า</th>
                                        <th width="100">ราคา</th>
                                        <th width="120">จำนวน</th>
                                        <th width="100">รวม</th>
                                        <th width="50">ลบ</th>
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
                                                <div class="input-group"
                                                    style="min-width: 100px; width: 100px; height: 50px;">
                                                    <button class="btn btn-warning btn-sm h-100 btn-minus p-0"
                                                        type="button" style="font-size: 20px; width: 30px;">-</button>

                                                    <input type="text"
                                                        class="form-control form-control-sm text-center h-100 qty-input p-0 update-cart"
                                                        data-id="{{ $id }}" readonly style="font-size: 16px;"
                                                        value="{{ $details['quantity'] }}">

                                                    <button class="btn btn-warning btn-sm h-100 btn-plus p-0" type="button"
                                                        style="font-size: 20px; width: 30px;">+</button>
                                                </div>
                                            </td>

                                            <td class="text-end fw-bold subtotal-{{ $id }}">
                                                {{ number_format($details['price'] * $details['quantity']) }}
                                            </td>
                                            <td class="text-center">
                                                <a data-bs-toggle="modal" data-bs-target="#delete{{ $id }}"><i
                                                        class="bi bi-x-circle-fill"></i></a>
                                            </td>

                                            <div class="modal fade" id="delete{{ $id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-danger">
                                                                <i class="fa-solid fa-triangle-exclamation"></i> ยืนยันการลบ
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            คุณแน่ใจหรือไม่ที่จะลบรายการนี้? <br>
                                                            <small
                                                                class="text-muted">การกระทำนี้ไม่สามารถย้อนกลับได้</small>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">ยกเลิก</button>
                                                            <a href="{{ route('cart.remove', $id) }}"
                                                                class="btn btn-danger">ยืนยันลบรายการสินค้า</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 mb-3">
                            <h2>
                                <i class="bi bi-pin-map me-2"></i> เลือกสาขาที่ติดตั้ง
                            </h2>
                            @if (isset($branch) && $branch)
                                <div class="card border-dark mt-3">
                                    <div class="card-body mb-3 mt-3">
                                        <h5 class="text-dark mb-4">
                                            {{ $branch->shop_name }} {{ $branch->branch_name }}
                                        </h5>
                                        <a href="{{ route('branch') }}" class="btn-search btn-sm">
                                            เปลี่ยนสาขา
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div id="branch-empty" style="display: block;">
                                    <a href="{{ route('branch') }}"
                                        class="btn-search mt-3 d-inline-block text-decoration-none text-center">
                                        ค้นหาสาขาใกล้ฉัน
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4 mb-3">
                            <h2>
                                <i class="bi bi-calendar3 me-2"></i> ตารางนัดหมาย
                            </h2>
                            <div class="card mb-4 mt-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="mb-3">วันที่เข้าใช้บริการ</label>
                                            <input type="text"
                                                class="form-control @error('booking_date') is-invalid @enderror"
                                                name="booking_date" id="booking_date" value="{{ session('booking_date') }}"
                                                placeholder="เลือกวันที่" required>
                                            @error('booking_date')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="mb-3">เวลา</label>
                                            <select class="form-control @error('booking_time') is-invalid @enderror"
                                                name="booking_time" id="booking_time" required>

                                                @if (isset($branch) && $branch && isset($branch->open_time) && isset($branch->close_time))
                                                    <option value="">-- เลือกเวลา --</option>

                                                    @php
                                                        $currentTime = strtotime($branch->open_time);
                                                        $closeTime = strtotime($branch->close_time . " -2 hour");
                                                        $now = time();
                                                    @endphp

                                                    @while ($currentTime < $closeTime)
                                                        @if ($currentTime > $now)
                                                            @php
                                                                $timeLabel = date('H:i', $currentTime);
                                                            @endphp

                                                            <option value="{{ $timeLabel }}">{{ $timeLabel }} น.
                                                            </option>
                                                        @endif

                                                        @php
                                                            $currentTime = strtotime('+1 hour', $currentTime);
                                                        @endphp
                                                    @endwhile
                                                @else
                                                    <option value="">-- กรุณาเลือกสาขาก่อน --</option>
                                                @endif

                                            </select>
                                            @error('booking_time')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- สรุปยอดเงิน --}}
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-blue text-white">
                                <h5 class="mb-0 text-white">สรุปคำสั่งซื้อ</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <span>ราคาสินค้าทั้งหมด</span>
                                    <span class="fw-bold" id="cart-subtotal">{{ number_format($total) }} บาท</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 text-danger">
                                    <span>ส่วนลด</span>
                                    <span>0 บาท</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="h5">ยอดรวมสุทธิ</span>
                                    <span class="h5 text-dark" id="grand-total">{{ number_format($total) }} บาท</span>
                                </div>

                                <div class="d-grid gap-2">
                                    {{-- ปุ่มไปหน้าชำระเงิน --}}
                                    <button type="submit" class="btn btn-warning btn-lg text-danger">
                                        <i class="bi bi-credit-card me-2"></i> ชำระเงิน
                                    </button>
                                    <a href="{{ route('home') }}" class="btn btn-outline-dark">
                                        เลือกซื้อสินค้าต่อ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- กรณีตะกร้าว่าง --}}
                <div class="text-center py-5">
                    <i class="bi bi-cart-x display-1 text-muted"></i>
                    <h3 class="mt-3">ไม่มีสินค้าในตะกร้า</h3>
                    <a href="{{ route('home') }}" class="btn btn-warning mt-3 text-danger">กลับไปเลือกซื้อสินค้า</a>
                </div>
            @endif
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>

    <script>
        $(document).ready(function() {

            $('.btn-minus').click(function(e) {
                e.preventDefault();
                var input = $(this).siblings('.qty-input');
                var val = parseInt(input.val());

                if (val > 1) {
                    input.val(val - 1);
                    updateCart(input);
                }
            });

            $('.btn-plus').click(function(e) {
                e.preventDefault();
                var input = $(this).siblings('.qty-input');
                var val = parseInt(input.val());

                input.val(val + 1);
                updateCart(input);
            });

            function updateCart(element) {
                var pid = element.attr("data-id");
                var qty = element.val();

                $.ajax({
                    url: '{{ route('update.cart') }}',
                    method: "patch",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: pid,
                        quantity: qty
                    },
                    success: function(response) {
                        $('.subtotal-' + pid).text(response.subtotal);
                        $('#cart-subtotal').text(response.total + ' บาท');
                        $('#grand-total').text(response.total + ' บาท');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>

    <script>
        var startDate = new Date();
        startDate.setDate(startDate.getDate() + 5);

        flatpickr("#booking_date", {
            dateFormat: "d/m/Y",
            minDate: startDate,
            locale: "th",
            disableMobile: "true"
        });
    </script>
@endsection
