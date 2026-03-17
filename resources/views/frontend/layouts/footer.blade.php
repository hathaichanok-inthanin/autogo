{{-- Footer --}}
<footer>
    <div class="container footer-content">
        <div class="footer-col">
            <h4>AUTOGO</h4>
            <p><i class="fas fa-map-marker-alt"></i> 4/51 หมู่ 1 ตำบลโคกกลอย อำเภอตะกั่วทุ่ง จังหวัดพังงา 82140</p>
            <p><a href=""><i class="fas fa-phone"></i> 096 634 1673</a></p>
        </div>
        <div class="footer-col">
            <h4>ค้นหายางรถยนต์</h4>
            <ul>
                <li><a href="{{ url('/') }}#tire-search">ค้นหายางตามขนาด</a></li>
                <li><a href="{{ url('product/tire/brand') }}">ค้นหายางทั่วไป</a></li>
                <li><a href="{{ url('product/tire-runflat/brand') }}">ค้นหายางรันแฟลต</a></li>
                <li><a href="{{ url('product/tire-ev/brand') }}">ค้นหายาง EV</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>เกี่ยวกับเรา</h4>
            <ul>
                <li><a href="{{ url('about-us') }}">รู้จัก AUTOGO</a></li>
                <li><a href="{{ url('branch') }}">ค้นหาสาขาใกล้บ้านคุณ</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>ช่วยเหลือ</h4>
            <ul>
                <li><a href="{{ url('how-to-order') }}">วิธีการสั่งซื้อ</a></li>
                <li><a href="{{ url('frequently-asked-questions') }}">คำถามที่พบบ่อย</a></li>
            </ul>
        </div> 
    </div>
</footer>
