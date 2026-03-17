@php
    $isOrdersActive = request()->routeIs('orders.*', 'appointments.index', 'installations.status');
@endphp

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ url('staff/dashboard') }}" class="brand-link">
            <img src="{{ asset('frontend/assets/image/logo.png') }}" alt="logo" class="brand-image" width="100%">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item">
                    <a href="{{ url('staff/dashboard') }}" class="nav-link">
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
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{ url('staff/orders') }}"
                                class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>รายการสั่งซื้อทั้งหมด</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('staff/orders/pending-payment') }}"
                                class="nav-link {{ request()->routeIs('orders.pending') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>รอชำระเงิน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('staff/appointments') }}"
                                class="nav-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>ตารางนัดหมายติดตั้ง</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('staff/orders/history') }}"
                                class="nav-link {{ request()->routeIs('orders.history') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>ประวัติการสั่งซื้อ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <hr>
                <li class="nav-item">
                    <a href="{{ route('staff.logout') }}"
                        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"
                        class="nav-link">
                        <i class="bi bi-box-arrow-right"></i>
                        <p>ออกจากระบบ</p>
                    </a>
                    <form id="logout-form"
                        action="{{ 'App\Models\Staff' == Auth::getProvider()->getModel() ? route('staff.logout') : route('staff.logout') }}"
                        method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
