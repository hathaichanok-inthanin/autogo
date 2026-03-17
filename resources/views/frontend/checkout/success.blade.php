@extends('frontend.layouts.template')

@section('content')
    <div class="container py-5 text-center">

        @if ($order->payment_status == 'waiting_verify')
            <i class="fa-solid fa-hourglass-half text-warning fa-4x mb-3"></i>
            <h2 class="fw-bold">แจ้งชำระเงินเรียบร้อย!</h2>
            <p class="lead text-muted">ขอบคุณสำหรับข้อมูลครับ ระบบได้รับสลิปของคุณแล้ว</p>
            <div class="alert alert-info d-inline-block mt-2">
                สถานะปัจจุบัน: <strong>รอเจ้าหน้าที่ตรวจสอบยอดเงิน (Waiting for Verify)</strong>
            </div>
        @else
            <i class="fa-solid fa-circle-check text-success fa-4x mb-3"></i>
            <h2 class="fw-bold">สั่งซื้อสำเร็จ</h2>
        @endif

        <div class="mt-4">
            <p class="text-muted">เลขคำสั่งซื้อของคุณ: <strong>#{{ $order->order_number }}</strong></p>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">กลับหน้าแรก</a>
        </div>
    </div>
@endsection
