@extends('frontend.layouts.template')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">

                <h4 class="opacity-75 mb-3 text-center">สรุปยอดชำระเงิน</h4>
                <h1 class="display-5 fw-bold text-warning text-center">{{ number_format($order->total_price, 2) }} บาท</h1>


                <div class="card card-qr shadow-lg mx-3">
                    <div class="card-body p-4 text-center">
                        @if (isset($qrImageBase64) && $qrImageBase64)
                            <div class="qr-frame mb-3">
                                <img id="qrCodeImage" src="data:image/png;base64,{{ $qrImageBase64 }}"
                                    style="max-width: 100%;">
                            </div>
                        @endif

                        <p class="text-muted small mb-4">สแกนจ่ายได้ทุกแอปธนาคาร</p>

                        <button class="btn btn-warning btn-save w-100 mb-2" onclick="downloadQR()">
                            <i class="bi bi-download"></i> บันทึกรูป QR Code
                        </button>

                        <div class="d-flex justify-content-center align-items-center text-danger">
                            <small class="fw-bold">กรุณาชำระภายใน <span id="countdown">15:00</span> นาที</small>
                        </div>
                    </div>
                </div>

                <div class="mt-4 px-3">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">เลขที่รายการ :</span>
                                <span class="fw-bold text-dark">#{{ $order->order_number }}</span>
                            </div>
                            @foreach ($order->orderDetails as $item)
                                <span class="fw-bold text-dark">{{ $item->product_name }}
                                    (x{{ $item->quantity }})
                                </span><br>
                            @endforeach
                            <div class="d-flex justify-content-between mb-2 mt-3">
                                <span class="text-muted">ยอดชำระเงิน :</span>
                                <span class="fw-bold text-dark">{{ number_format($order->total_price, 2) }} บาท</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderId = "{{ $order->id }}";

            const checkUrl = "{{ route('checkout.check_status', $order->id) }}";

            setInterval(function() {
                fetch(checkUrl)
                    .then(res => res.json())
                    .then(data => {
                        console.log('Status:', data.status);

                        if (data.status === 'paid') {
                            window.location.href = "{{ route('checkout.success', $order->id) }}";
                        }
                    })
                    .catch(err => console.error(err));
            }, 3000);
        });
    </script>

    <script>
        function downloadQR() {
            const img = document.getElementById('qrCodeImage');
            const url = img.src;
            const link = document.createElement('a');
            link.href = url;
            link.download = 'qrcode_payment.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>

    <script>
        let timeInSeconds = 900;
        const display = document.querySelector('#countdown');
        const orderId = "{{ $order->id }}";

        function startTimer() {
            const timer = setInterval(function() {
                let minutes = Math.floor(timeInSeconds / 60);
                let seconds = timeInSeconds % 60;

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                display.textContent = minutes + ":" + seconds;

                if (--timeInSeconds < 0) {
                    clearInterval(timer);
                    display.textContent = "00:00";

                    handleTimeout();
                }
            }, 1000);
        }

        async function handleTimeout() {
            const url = "{{ url('/order/cancel') }}/" + orderId;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.status === 'success') {
                    console.log('ลบออเดอร์เรียบร้อย');
                }
            } catch (error) {
                console.error('เกิดข้อผิดพลาดในการลบ:', error);
            } finally {
                window.location.href = "{{ url('/') }}";
            }
        }

        window.onload = function() {
            startTimer();
        };
    </script>
@endsection
