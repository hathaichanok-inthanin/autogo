@extends('frontend/layouts/template')

@section('content')
    <div class="container" style="margin-bottom: 5rem;">
        <h4 class="text-header text-center mt-5 mb-5"><i class="fas fa-map-marker-alt"></i> ค้นหาสาขาใกล้บ้านคุณ</h4>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="searchForm" class="search-box" onsubmit="return false;">
                        <div class="form-group">
                            <label>ค้นหาจากสถานที่ใกล้เคียงหรือรหัสไปรษณีย์</label>
                            <input type="text" id="keyword" class="form-control"
                                placeholder="กรอกชื่อถนน, เขต หรือ รหัสไปรษณีย์">
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
                            <button type="button" onclick="searchShops()" class="btn-search">
                                ค้นหา
                            </button>

                            <button type="button" onclick="getLocation()" class="btn-search">
                                <i class="fas fa-map-marker-alt"></i> ระบุตำแหน่งของฉัน
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="loading" class="text-center d-none py-5">
            <div class="spinner-border text-warning" role="status"></div>
            <p class="mt-2 text-muted">กำลังค้นหาสาขาใกล้คุณ...</p>
        </div>

        <div id="result-container" class="row g-4">
        </div>

        <div id="no-result" class="text-center d-none py-5">
            <i class="fa-solid fa-shop-slash fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">ไม่พบสาขาในบริเวณนี้</h5>
            <p>ลองขยายระยะทางหรือค้นหาด้วยคำอื่น</p>
        </div>
    </div>

    {{-- Script การทำงาน --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                $('#loading').removeClass('d-none');
                $('#result-container').empty();

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        searchShops(lat, lng);
                    },
                    (error) => {
                        $('#loading').addClass('d-none');
                        alert("ไม่สามารถระบุตำแหน่งได้ กรุณาเปิด GPS หรือกรอกคำค้นหาแทน");
                        console.error(error);
                    }
                );
            } else {
                alert("Browser ของคุณไม่รองรับการระบุตำแหน่ง");
            }
        }

        function searchShops(lat = null, lng = null) {
            const keyword = $('#keyword').val();
            const radius = $('#radius').val();

            if (!lat && !keyword) {
                alert('กรุณากรอกคำค้นหา หรือกดปุ่มระบุตำแหน่ง');
                return;
            }

            $('#loading').removeClass('d-none');
            $('#result-container').empty();
            $('#no-result').addClass('d-none');

            $.ajax({
                url: './api/shops/search', 
                method: 'GET',
                data: {
                    lat: lat,
                    lng: lng,
                    keyword: keyword,
                    radius: radius
                },
                success: function(response) {
                    $('#loading').addClass('d-none');

                    if (response.length > 0) {
                        renderShops(response);
                    } else {
                        $('#no-result').removeClass('d-none');
                    }
                },
                error: function(err) {
                    $('#loading').addClass('d-none');
                    alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
                }
            });
        }

        function renderShops(shops) {
            let html = '';
            shops.forEach(shop => {
                let imagePath = shop.shop_image ?
                    `{{ asset('/image_upload/shop_image') }}/${shop.shop_image}` :
                    'https://via.placeholder.com/400x300?text=No+Image';

                let distanceHtml = '';
                if (shop.distance) {
                    distanceHtml =
                        `<div class="distance-badge mt-3" style="padding-left: 1rem;"><i class="fa-solid fa-location-arrow me-1"></i> ${parseFloat(shop.distance).toFixed(1)} km</div>`;
                }

                let mapLink =
                    `https://www.google.com/maps/dir/?api=1&destination=${shop.latitude},${shop.longitude}`;
                let selectUrl = `./branch/select/${shop.id}`;
                let branchDetail = `./branch-detail/${shop.id}`;

                html += `
                <div class="col-md-4 mt-5">
                    <div class="card card-branch">
                        <img class="card-img-top" src="${imagePath}" alt="${shop.shop_name}">
                            ${distanceHtml}
                        <div class="card-body">
                            <h5 class="card-title">${shop.shop_name} ${shop.branch_name}</h5>
                            <p class="card-text">${shop.address_text} ตำบล${shop.subdistrict} อำเภอ${shop.district} จังหวัด${shop.province}</p>
                            <a href="tel:${shop.phone}" class="btn btn-outline-secondary btn-sm rounded-pill">
                                <i class="fa-solid fa-phone"></i> โทร : ${shop.phone}
                            </a>
                            <hr>
                            <div class="mt-3 mb-3">
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <a href="${selectUrl}" class="btn-search btn-block text-center">เลือกสาขาติดตั้ง</a>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <a href="${branchDetail}" class="btn-search btn-block text-center">ดูรายละเอียด</a>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <a href="${mapLink}" target="_blank" class="btn-search btn-block fw-bold">
                                            <i class="fa-solid fa-directions"></i> ดู Google Map
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            `;
            });

            $('#result-container').html(html);
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const lat = urlParams.get('lat');
            const lng = urlParams.get('lng');
            const keyword = urlParams.get('keyword');
            const distance = urlParams.get('distance');

            if (lat || keyword) {
                console.log("รับค่าจากหน้าแรก:", {
                    lat,
                    lng,
                    keyword,
                    distance
                });

                if (document.getElementById('keyword')) document.getElementById('keyword').value = keyword || '';
                if (document.getElementById('distance')) document.getElementById('distance').value = distance ||
                    '10';
                if (document.getElementById('lat')) document.getElementById('lat').value = lat || '';
                if (document.getElementById('lng')) document.getElementById('lng').value = lng || '';

                if (typeof getLocation === "function") {
                    getLocation();
                } else {
                    console.error("ไม่พบฟังก์ชัน getLocation() ในหน้านี้");
                }
            }
        });
    </script>
@endsection
