<style>

</style>
<header id="header" class="header sticky-top">
    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-end">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a
                        href="mailto:contact@example.com">contact@example.com</a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>096 634 1673</span></i>
            </div>
        </div>
    </div>
    <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
                <img src="{{ asset('frontend/assets/image/logo.png') }}" alt="logo" class="img-responsive"
                    width="100%">
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/') }}"
                            class="{{ request()->routeIs('home') ? 'active' : '' }}">หน้าหลัก<br></a></li>
                    <li class="dropdown"><a href="#"><span>ยางรถยนต์</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ url('product/tire/brand') }}">ยางรถยนต์ทั่วไป</a></li>
                            <li><a href="{{ url('product/tire-runflat/brand') }}">ยางรถยนต์รันแฟลต</a></li>
                            <li><a href="{{ url('product/tire-ev/brand') }}">ยางรถยนต์ EV</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('promotion') }}"
                            class="{{ request()->routeIs('promotion') ? 'active' : '' }}">โปรโมชั่น</a></li>
                    <li><a href="{{ url('branch') }}"
                            class="{{ request()->routeIs('branch') ? 'active' : '' }}">สาขาใกล้บ้านคุณ</a></li>
                    <li><a href="{{ url('about-us') }}"
                            class="{{ request()->routeIs('about-us') ? 'active' : '' }}">เกี่ยวกับเรา</a></li>
                    <li><a href="{{ url('contact-us') }}"
                            class="{{ request()->routeIs('contact-us') ? 'active' : '' }}">ติดต่อเรา</a></li>
                    {{-- <li class="d-xl-none mt-3 mb-3">
                        <div class="auth-pill-wrapper-mobile d-inline-flex justify-content-center">
                            <a href="{{ route('login') }}" class="auth-link-mobile">เข้าสู่ระบบ</a>
                            <span class="auth-separator-mobile">/</span>
                            <a href="{{ route('register') }}" class="auth-link-mobile">ลงทะเบียน</a>
                        </div>
                    </li> --}}
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-dark position-relative me-2">
                <i class="bi bi-cart3"></i>
                <span id="cart-count"
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ count(session('cart', [])) }}
                </span>
            </a>
            {{-- <div class="auth-pill-wrapper d-none d-sm-block"> --}}
                {{-- @guest('member')
                    <a href="{{ route('login') }}" class="auth-link">
                        เข้าสู่ระบบ
                    </a>
                    <span class="auth-separator">/</span>
                    <a href="{{ route('register') }}" class="auth-link">
                        ลงทะเบียน
                    </a>
                @endguest --}}

                {{-- กรณี: ล็อกอินแล้ว (Member) --}}
                {{-- @auth('member')
                    <span class="auth-link text-primary">
                        <i class="fas fa-user-circle"></i>
                        {{ Auth::guard('member')->user()->name }}
                    </span>
                    <span class="auth-separator">/</span>

                    <a href="{{ route('logout') }}" class="auth-link text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        ออกจากระบบ
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth --}}
            {{-- </div> --}}

        </div>
    </div>
</header>