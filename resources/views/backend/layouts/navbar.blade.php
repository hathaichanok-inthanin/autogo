@php
    $isSettingsActive = request()->routeIs(
        'settings.general',
        'settings.service_areas.*',
        'settings.payment_methods.*',
        'settings.shipping_rates.*',
    );
    $isOrdersActive = request()->routeIs('orders.*', 'appointments.index', 'installations.status');
    $isProductActive = request()->routeIs(
        'products.index',
        'products.create',
        'categories.index',
        'brands.index',
        'product_models.index',
        'tire_sizes.index',
        'inventory.index',
    );
    $isShopsActive = request()->routeIs('shops.index', 'shops.requests', 'commissions.index', 'shops.balance');
    $isUserActive = request()->routeIs('users.*');
    $isMarketingActive = request()->routeIs('marketing.*', 'articles.index');
    $isAccountingActive = request()->routeIs('reports.*', 'tax_invoices.index');
    $isSettingProductActive = request()->routeIs('categories.index');
@endphp

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ url('admin/dashboard') }}" class="brand-link">
            <img src="{{ asset('frontend/assets/image/logo.png') }}" alt="logo" class="brand-image" width="100%">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ $isOrdersActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-calendar-event-fill"></i>
                        <p>
                            การสั่งซื้อ / การนัดหมาย
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/orders') }}"
                                class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>รายการสั่งซื้อทั้งหมด</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/orders/pending-payment') }}"
                                class="nav-link {{ request()->routeIs('orders.pending') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>รอชำระเงิน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/appointments') }}"
                                class="nav-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>ตารางนัดหมายติดตั้ง</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/orders/history') }}"
                                class="nav-link {{ request()->routeIs('orders.history') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>ประวัติการสั่งซื้อ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ $isProductActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-bag-fill"></i>
                        <p>
                            จัดการสินค้า
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ $isSettingProductActive ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>
                                    ตั้งค่าหมวดหมู่
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('admin/products/categories') }}"
                                        class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-record-circle-fill"></i>
                                        <p>หมวดหมู่สินค้า</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/products') }}"
                                class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>สินค้าทั้งหมด</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/products/create') }}"
                                class="nav-link {{ request()->routeIs('products.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>เพิ่มสินค้าใหม่</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/products/brands') }}"
                                class="nav-link {{ request()->routeIs('brands.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>จัดการแบรนด์สินค้า</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/products/models') }}"
                                class="nav-link {{ request()->routeIs('product_models.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>จัดการรุ่นสินค้า</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/products/tire-sizes') }}"
                                class="nav-link {{ request()->routeIs('tire_sizes.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>จัดการขนาดยาง</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ $isShopsActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-shop-window"></i>
                        <p>
                            จัดการร้านค้า
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/shops') }}"
                                class="nav-link {{ request()->routeIs('shops.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>รายชื่อร้านค้าทั้งหมด</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ $isUserActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            ผู้ใช้งาน
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/users/admins') }}"
                                class="nav-link {{ request()->routeIs('users.admins.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>บัญชีของแอดมิน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/users/partners') }}"
                                class="nav-link {{ request()->routeIs('users.partners.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>บัญชีของร้านค้า</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ $isMarketingActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-camera-reels-fill"></i>
                        <p>
                            โปรโมชั่น
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/marketing/promotions') }}"
                                class="nav-link {{ request()->routeIs('marketing.promotions.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>โปรโมชั่น</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ $isAccountingActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-text-fill"></i>
                        <p>
                            บัญชีและรายงาน
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/reports/sales') }}"
                                class="nav-link {{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>รายงานยอดขาย</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/message') }}" class="nav-link">
                        <i class="nav-icon bi bi-chat-square-text-fill"></i>
                        <p>ข้อความติดต่อจากลูกค้า</p>
                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <a href="{{ route('admin.logout') }}"
                        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"
                        class="nav-link">
                        <i class="bi bi-box-arrow-right"></i>
                        <p>ออกจากระบบ</p>
                    </a>
                    <form id="logout-form"
                        action="{{ 'App\Models\Admin' == Auth::getProvider()->getModel() ? route('admin.logout') : route('admin.logout') }}"
                        method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
