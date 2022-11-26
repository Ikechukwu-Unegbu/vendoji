<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="{{ route('public.home') }}" class="logo d-flex align-items-center">
            <img src="{{ !empty($settings['site_logo']) ? asset($settings['site_logo']) : asset('site-logo/default-logo.png') }}"
                alt="">
            <span>Vendoji</span>
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="/">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">About</a></li>
                <li><a class="nav-link scrollto" href="#services">Services</a></li>
                <!-- <li><a class="nav-link scrollto" href="#portfolio">Portfolio</a></li> -->
                <li><a class="nav-link scrollto" href="#team">Team</a></li>
                <!-- <li><a href="blog.html">Blog</a></li> -->

                <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                @auth
                    <li><a class="getstarted scrollto" href="{{ Auth::user()->access == 'user' ? route('dashboard') : route('admin') }}">Dashboard</a></li>
                @else
                    <li><a class="getstarted scrollto" href="{{ route('register') }}">Register</a></li>
                    <li><a class="getstarted scrollto" href="{{ route('login') }}">Login</a></li>
                @endauth
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->

    </div>
</header>
