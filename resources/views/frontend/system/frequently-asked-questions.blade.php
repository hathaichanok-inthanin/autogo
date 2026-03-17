@extends('frontend/layouts/template')
<style>
    .accordion-button {
        background-color: #ffcb10 !important;
        color: #ec3d19 !important;
        font-weight: bold;
    }

    .accordion-item {
        border-top : solid 2px #095C8A !important
    }
</style>
@section('content')
    <div class="container mt-5">
        <div class="accordion" id="myAccordion">

            <div class="accordion-item" >
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        1. สั่งออนไลน์แล้วไปเปลี่ยนยางที่ไหนได้บ้าง?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#myAccordion">
                    <div class="accordion-body">
                        คุณสามารถเลือกเข้ารับบริการได้ที่ศูนย์บริการในเครือข่ายของเราที่ใกล้บ้านคุณ (ค้นหาสาขาได้ที่เมนู "สาขาใกล้บ้านคุณ")
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        2. หากไม่แน่ใจขนาดไซส์ยาง ควรทำอย่างไร?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#myAccordion">
                    <div class="accordion-body">
                        <p>วิธีที่ชัวร์ที่สุด คือ การดูตัวเลขที่ระบุอยู่บนแก้มยางเส้นที่ใช้อยู่ โดยมองหาชุดตัวเลขในรูปแบบ: 185/60 R15</p>
                        <p>185 : ความกว้างหน้ายาง (มิลลิเมตร)</p>
                        <p>60 : ซีรีส์ยาง (ความสูงแก้มยางเป็น % ของหน้ายาง)</p>
                        <p>R15 : ขนาดเส้นผ่านศูนย์กลางล้อแม็ก (นิ้ว)</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingthree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        3. AUTOGO มีขายยางยี่ห้อไหนบ้าง?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingthree"
                    data-bs-parent="#myAccordion">
                    <div class="accordion-body">
                        เรามีครบทุกแบรนด์ชั้นนำ เช่น Michelin, BF Goodrich, Otani, Bridgestone และแบรนด์คุณภาพอื่นๆ กว่า 100 รุ่น ครบทุกรุ่น ทุกขนาด
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingfour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        4. ใช้เวลานานไหมกว่าจะได้รับยางหรือเข้าติดตั้งได้?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingfour"
                    data-bs-parent="#myAccordion">
                    <div class="accordion-body">
                        โดยปกติหลังจากยืนยันการสั่งซื้อ คุณลูกค้าสามารถนัดหมายเข้าติดตั้งได้ภายใน 5-7 วันทำการ
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
