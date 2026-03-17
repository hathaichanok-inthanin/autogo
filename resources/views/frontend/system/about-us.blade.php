@extends('frontend/layouts/template')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold text-uppercase text-blue">เกี่ยวกับ <span class="text-warning">AUTOGO</span>
                    </h2>
                    <p class="lead text-muted">"ยางกว่า 100 รุ่น ราคามาตรฐาน การันตีคุณภาพ"</p>
                    <div class="border-start border-4 ps-3 my-4" style="border-color:#095C8A !important">
                        <p>ความมุ่งมั่นในการดำเนินงานของเรา เพื่อให้ AUTOGO เป็นมากกว่าร้านค้าออนไลน์
                            แต่เป็นศูนย์รวมยางรถยนต์ที่คุณวางใจได้มากที่สุด เราตั้งใจคัดสรรทางเลือกที่หลากหลาย
                            ภายใต้ราคาที่เป็นธรรมและโปร่งใส เพื่อให้มั่นใจว่าลูกค้าของเรา จะได้รับสิ่งที่ดีที่สุด...
                            ทั้งเพื่อรถ
                            และเพื่อความปลอดภัยของคุณ</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('frontend/assets/image/branch/bypass.png') }}" width="100%"
                        class="img-responsive img-fluid rounded-4 shadow-lg">
                </div>
            </div>

            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4" style="border-top: 5px solid #095c8a !important;">
                        <i class="bi-grid-3x3-gap text-blue mb-3" style="font-size: 2rem;"></i>
                        <h4>อิสระแห่งการเลือกสรร</h4>
                        <p class="small text-muted">คัดสรรยางรถยนต์คุณภาพจากแบรนด์ชั้นนำทั่วโลก</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4" style="border-top: 5px solid #095c8a !important;">
                        <i class="bi bi-tags text-blue mb-3" style="font-size: 2rem;"></i>
                        <h4>มาตรฐานราคาที่ชัดเจน</h4>
                        <p class="small text-muted">มั่นใจกับราคากลางที่เป็นมาตรฐาน ไม่หมกเม็ด จริงใจ
                            ให้คุณได้รับความคุ้มค่าสูงสุดในราคาที่สบายใจ</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4" style="border-top: 5px solid #095c8a !important;">
                        <i class="bi bi-shield-check text-blue mb-3" style="font-size: 2rem;"></i>
                        <h4>การันตีคุณภาพ 100%</h4>
                        <p class="small text-muted">ยางใหม่ ผ่านการตรวจสอบมาตรฐานการผลิตอย่างเข้มงวด
                            พร้อมการรับประกันสินค้าที่ชัดเจนในทุกเส้น</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
