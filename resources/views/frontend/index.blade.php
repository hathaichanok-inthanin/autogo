@extends('frontend/layouts/template')
<style>
    .banner-container {
        height: 500px;
        position: relative;
        overflow: hidden;
    }

    .banner-img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }

    @media (max-width: 768px) {
        .banner-container {
            height: auto !important;
        }

        .banner-img {
            position: relative !important;
            height: auto !important;
            object-fit: contain;
        }
    }
</style>
@section('content')
    <div class="banner-container">
        <img src="{{ url('frontend/assets/image/banner.png') }}" class="banner-img" alt="Banner">
    </div>

    <div class="container">
        <section class="search-section" id="tire-search">
            <h5><i class="fas fa-search"></i> ค้นหายางตามขนาด</h5>
            <hr>
            <form class="search-form" action="{{ route('tires.search') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>หน้ากว้างยาง</label>
                    <select name="width" id="width">
                        <option>เลือกหน้ากว้างยาง</option>
                        @foreach ($widths as $width)
                            <option value="{{ $width }}">{{ $width }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>ความสูงแก้มยาง</label>
                    <select name="ratio" id="ratio" disabled>
                        <option>เลือกความสูงแก้มยาง</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>เส้นผ่านศูนย์กลาง</label>
                    <select name="rim" id="rim" disabled>
                        <option>เลือกเส้นผ่านศูนย์กลาง</option>
                    </select>
                </div>
                <button type="submit" class="btn-search">ค้นหายางรถยนต์</button>
            </form>
        </section>

        <div class="branch-search">
            <h5><i class="fas fa-map-marker-alt"></i> ค้นหาศูนย์บริการ</h5>
        </div>
        <form id="searchForm" class="search-box" onsubmit="return false;">
            <div class="form-group">
                <label>ค้นหาจากสถานที่ใกล้เคียงหรือรหัสไปรษณีย์</label>
                <input type="text" id="keyword" class="form-control" placeholder="กรอกชื่อถนน, เขต หรือ รหัสไปรษณีย์">
                <input type="hidden" id="lat" name="lat">
                <input type="hidden" id="lng" name="lng">
            </div>

            <div class="form-group distance-select">
                <label>ระยะทางไม่เกิน</label>
                <select id="distance" class="form-control">
                    <option value="5">5 km</option>
                    <option value="10" selected>10 km</option>
                    <option value="20">20 km</option>
                    <option value="50">50 km</option>
                </select>
            </div>

            <div class="action-buttons">
                <button type="button" onclick="searchBranches()" class="btn-search">
                    ค้นหา
                </button>

                <button type="button" onclick="getLocation()" class="btn-search">
                    <i class="fas fa-map-marker-alt"></i> ระบุตำแหน่งของฉัน
                </button>
            </div>
        </form>
        <div class="services-grid mt-5">
            <a href="{{ url('product/tire/brand') }}">
                <div class="service-card">
                    <div class="service-icon-box mb-3">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="section-title">ยางรถยนต์ทั่วไป</h3>
                </div>
            </a>

            <a href="{{ url('product/tire-runflat/brand') }}">
                <div class="service-card">
                    <div class="service-icon-box mb-3">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="section-title">ยางรถยนต์รันแฟลต</h3>
                </div>
            </a>

            <a href="{{ url('product/tire-ev/brand') }}">
                <div class="service-card">
                    <div class="service-icon-box">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="section-title">ยางรถยนต์ EV</h3>
                </div>
            </a>
        </div>
    </div>


    {{-- Script --}}
    <script>
        document.getElementById('width').addEventListener('change', function() {
            var widthId = this.value;
            var ratioDropdown = document.getElementById('ratio');
            var rimDropdown = document.getElementById('rim');

            ratioDropdown.innerHTML = '<option value="">กำลังโหลด...</option>';
            rimDropdown.innerHTML = '<option value="">เลือกเส้นผ่านศูนย์กลาง</option>';
            rimDropdown.disabled = true;

            if (widthId) {
                fetch('./get-ratios?width=' + widthId)
                    .then(response => response.json())
                    .then(data => {
                        ratioDropdown.innerHTML = '<option value="">เลือกความสูงแก้มยาง</option>';
                        ratioDropdown.disabled = false;

                        data.forEach(value => {
                            var option = document.createElement('option');
                            option.value = value;
                            option.text = value;
                            ratioDropdown.appendChild(option);
                        });
                    });
            } else {
                ratioDropdown.innerHTML = '<option value="">กรุณาเลือกหน้ากว้างก่อน</option>';
                ratioDropdown.disabled = true;
            }
        });

        document.getElementById('ratio').addEventListener('change', function() {
            var widthId = document.getElementById('width').value;
            var ratioId = this.value;
            var rimDropdown = document.getElementById('rim');

            rimDropdown.innerHTML = '<option value="">กำลังโหลด...</option>';

            if (ratioId) {
                fetch('./get-rims?width=' + widthId + '&ratio=' + ratioId)
                    .then(response => response.json())
                    .then(data => {
                        rimDropdown.innerHTML = '<option value="">เลือกเส้นผ่านศูนย์กลาง</option>';
                        rimDropdown.disabled = false;

                        data.forEach(value => {
                            var option = document.createElement('option');
                            option.value = value;
                            option.text = value;
                            rimDropdown.appendChild(option);
                        });
                    });
            } else {
                rimDropdown.innerHTML = '<option value="">เลือกเส้นผ่านศูนย์กลาง</option>';
                rimDropdown.disabled = true;
            }
        });
    </script>

    <script>
        const SEARCH_RESULT_PAGE = "branch";

        function searchBranches() {
            const keyword = document.getElementById('keyword').value;
            const distance = document.getElementById('distance').value;
            const lat = document.getElementById('lat').value;
            const lng = document.getElementById('lng').value;

            const params = new URLSearchParams();

            if (lat && lng) {
                params.append('lat', lat);
                params.append('lng', lng);
            } else if (keyword) {
                params.append('keyword', keyword);
            }

            params.append('distance', distance);

            window.location.href = `${SEARCH_RESULT_PAGE}?${params.toString()}`;
        }

        function getLocation() {
            if (navigator.geolocation) {
                const btn = event.currentTarget;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังระบุตำแหน่ง...';
                btn.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        document.getElementById('lat').value = position.coords.latitude;
                        document.getElementById('lng').value = position.coords.longitude;

                        searchBranches();
                    },
                    (error) => {
                        console.error("Error getting location:", error);
                        alert("ไม่สามารถระบุตำแหน่งได้ กรุณาลองใหม่อีกครั้ง หรือพิมพ์ค้นหาแทน");

                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                );
            } else {
                alert("เบราว์เซอร์ของคุณไม่รองรับการระบุตำแหน่ง");
            }
        }
    </script>
@endsection
