<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ค้นหาสาขา</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ffc400; /* สีเหลืองตามรูป */
            --primary-hover: #e6b000;
            --text-dark: #333;
            --border-color: #ddd;
        }

        body {
            font-family: 'Sarabun', sans-serif; /* แนะนำให้ใช้ฟอนต์ไทย */
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            color: var(--text-dark);
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Header Section */
        .search-header {
            margin-bottom: 20px;
        }
        
        .search-header h1 {
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form Styling */
        .search-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            flex-wrap: wrap; /* Key for Responsive */
            gap: 15px;
            align-items: flex-end;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .distance-select {
            max-width: 150px;
        }

        /* Buttons */
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: #000;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        /* Responsive Buttons logic */
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .search-box {
                flex-direction: column;
                align-items: stretch;
            }
            .distance-select {
                max-width: 100%;
            }
            .action-buttons {
                flex-direction: column;
            }
            .btn {
                width: 100%;
            }
        }

        /* Results Section */
        #results-area {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .branch-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            transition: transform 0.2s;
        }
        
        .branch-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .branch-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #000;
        }
        
        .branch-distance {
            color: #d32f2f;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .loading {
            text-align: center;
            width: 100%;
            padding: 20px;
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="search-header">
        <h1><i class="fas fa-map-marker-alt"></i> ค้นหาสาขา</h1>
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
            <button type="button" onclick="searchBranches()" class="btn btn-primary">
                ค้นหา
            </button>
            
            <button type="button" onclick="getLocation()" class="btn btn-primary">
                <i class="fas fa-map-marker-alt"></i> ระบุตำแหน่งของฉัน
            </button>
        </div>
    </form>

    <div id="loading" class="loading">กำลังค้นหา...</div>
    <div id="results-area">
        </div>
</div>

<script>
    // ฟังก์ชันขอพิกัดปัจจุบัน (Geolocation)
    function getLocation() {
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังระบุ...';
        btn.disabled = true;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Browser ของคุณไม่รองรับ Geolocation");
            resetBtn(btn, originalText);
        }

        function showPosition(position) {
            document.getElementById('lat').value = position.coords.latitude;
            document.getElementById('lng').value = position.coords.longitude;
            document.getElementById('keyword').value = "ตำแหน่งปัจจุบันของคุณ";
            
            // สั่งค้นหาทันทีเมื่อได้พิกัด
            searchBranches(); 
            resetBtn(btn, originalText);
        }

        function showError(error) {
            let msg = "";
            switch(error.code) {
                case error.PERMISSION_DENIED: msg = "ผู้ใช้ปฏิเสธการเข้าถึงตำแหน่ง"; break;
                case error.POSITION_UNAVAILABLE: msg = "ข้อมูลตำแหน่งไม่สามารถใช้งานได้"; break;
                case error.TIMEOUT: msg = "หมดเวลาในการร้องขอตำแหน่ง"; break;
                default: msg = "เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ";
            }
            alert(msg);
            resetBtn(btn, originalText);
        }
    }

    function resetBtn(btn, text) {
        btn.innerHTML = text;
        btn.disabled = false;
    }

    // ฟังก์ชันส่งข้อมูลไป Backend
    function searchBranches() {
        const keyword = document.getElementById('keyword').value;
        const lat = document.getElementById('lat').value;
        const lng = document.getElementById('lng').value;
        const distance = document.getElementById('distance').value;

        document.getElementById('loading').style.display = 'block';
        document.getElementById('results-area').innerHTML = '';

        fetch('{{ route("branch.search") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ keyword, lat, lng, distance })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loading').style.display = 'none';
            renderResults(data);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('loading').style.display = 'none';
        });
    }

    function renderResults(branches) {
        const container = document.getElementById('results-area');
        if (branches.length === 0) {
            container.innerHTML = '<p style="text-align:center; width:100%;">ไม่พบสาขาในเงื่อนไขที่กำหนด</p>';
            return;
        }

        let html = '';
        branches.forEach(branch => {
            // ถ้ามี distance ให้แสดงระยะทาง
            let distanceText = branch.distance 
                ? `<div class="branch-distance"><i class="fas fa-location-arrow"></i> ห่าง ${parseFloat(branch.distance).toFixed(1)} กม.</div>` 
                : '';

            html += `
                <div class="branch-card">
                    <div class="branch-name">${branch.name}</div>
                    ${distanceText}
                    <div style="color:#666; font-size:14px;">${branch.address} ${branch.zipcode}</div>
                    <div style="margin-top:10px;">
                        <a href="https://www.google.com/maps/dir/?api=1&destination=${branch.latitude},${branch.longitude}" target="_blank" 
                           style="color:#000; text-decoration:underline; font-size:14px;">
                           นำทาง
                        </a>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
    }
</script>

</body>
</html>