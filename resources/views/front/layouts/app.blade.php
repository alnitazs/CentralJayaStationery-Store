<!DOCTYPE html>
<html class="no-js" lang="en_AU">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Central Jaya Stationery</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <meta property="og:locale" content="en_AU" />
    <meta property="og:type" content="website" />
    <meta property="fb:admins" content="" />
    <meta property="fb:app_id" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:image:alt" content="" />

    <meta name="twitter:title" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:image:alt" content="" />
    <meta name="twitter:card" content="summary_large_image" />


    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick-theme.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/ion.rangeSlider.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.css') }}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">

    {{-- Fav Icon --}}
    <link rel="shortcut icon" type="image/x-icon" href="#" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body data-instant-intensity="mousedown">
{{-- @if (!Request::is('login'))
    @include('partials.header')
@endif --}}

    {{-- Header --}}
    <div class="bg-light top-header">
        <div class="container">
            <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
                {{-- Logo --}}
                <div class="col-lg-3">
                    <a href="{{ route('front.home') }}" class="text-decoration-none">
                        <span class="h5 text-uppercase text-warning fw-bold">Central Jaya Stationery</span>
                    </a>
                </div>

                {{-- Navigation Header--}}
                <div class="col-lg-5 d-flex justify-content-center">
                    <nav>
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="{{ route('front.home') }}" class="nav-link text-dark fw-bold">Beranda</a>
                            </li>
                            @php
                                $tentangKami = staticPages()->firstWhere('name', 'Tentang Kami');
                            @endphp

                            @if ($tentangKami)
                                <li class="nav-item">
                                    <a href="{{ route('front.page', $tentangKami->slug) }}" class="nav-link text-dark fw-bold">
                                        {{ $tentangKami->name }}
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('front.shop') }}" class="nav-link text-dark fw-bold">Produk</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                {{-- Search, Account & Cart --}}
                <div class="col-lg-4 d-flex justify-content-end align-items-center">

                    <form action="{{ route('front.shop') }}" class="d-flex align-items-center">
                        <div class="input-group">
                            <input value="{{ Request::get('search') }}" type="text" placeholder="Cari Produk" class="form-control" name="search" id="search">
                            <button type="submit" class="btn btn-light">
                                {{-- Ubah ke btn-light biar abu --}}
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>

                    {{-- Account Icon --}}
                    @if(Auth::check())
                        <a href="{{ route('account.profile') }}" class="nav-link text-dark">
                            <i class="fas fa-user text-dark fs-4"></i>
                        </a>
                    @else
                        <a href="{{ route('account.login') }}" class="nav-link text-dark">Login/Register</a>
                    @endif

                    {{-- Cart --}}
                    <a href="{{ route('front.cart') }}" class="#">
                        <i class="fas fa-shopping-cart text-warning fs-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <header class="bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-xl" id="navbar">
                <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <i class="navbar-toggler-icon fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if(getCategories()->isNotEmpty())
                        @foreach (getCategories() as $category)
                        <li class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                                {{ $category->name }}
                            </button>
                            @if ($category->sub_category->isNotEmpty())
                            <ul class="dropdown-menu dropdown-menu-dark">
                                @foreach ($category->sub_category as $subCategory)
                                <li>
                                    <a class="dropdown-item nav-link" href="{{ route('front.shop',[$category->slug,$subCategory->slug]) }}">
                                        {{ $subCategory->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    {{-- Shop page --}}
    <main>
        @yield('content')
    </main>

    {{-- footer --}}
    <footer class="footer mt-5">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <img src="/front-assets/images/Logo.png" class="footer-logo">
                    <h2>Central Jaya Stationery</h2>
                    <p>Belanja Alat Tulis Menjadi Lebih Mudah dan Cepat</p>
                </div>
                <div class="footer-section">
                    <h3>Address</h3>
                    <p>Jln Laut Rt 02 Rw 07 Adipala,<br>Cilacap, Jawa Tengah, 53271</p>
                    <p>+62 896 9229 2332</p>
                </div>
                <div class="footer-section">
                    <h3>Additional Navigation</h3>
                    <ul>
                        @if (staticPages()->isNotEmpty())
                            @foreach (staticPages() as $page)
                                <li><a href="{{ route('front.page',$page->slug) }}" title="{{ $page->name }}">{{ $page->name }}</a></li>
                            @endforeach
                        @endif
                        {{-- <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Terms & Conditions</a></li> 
                        https://maps.app.goo.gl/vMsnH1aiXQSb6kHU6--}}
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Media</h3>
                    <ul>
                        <li><a href="https://wa.me/089692292332">WhatsApp</a></li>
                        <li><a href="https://www.facebook.com/share/198DKLQaoa/">Facebook</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© 2025 Central Jaya</span>
                <span>|</span>
                <a href="#">Privacy & Policy</a>
            </div>
        </div>
    </footer>

    {{-- Wishlist Modal --}}
    <div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sukses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/custom.js') }}"></script>

    <script>
        window.onscroll = function() {
            myFunction()
        };

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function addToCart(id) {
            $.ajax({
                url: '{{ route("front.addToCart") }}', 
                type: 'post', 
                data: { id: id }, 
                dataType: 'json', 
                success: function(response) {
                    if (response.status == true) {
                        window.location.href = "{{ route('front.cart') }}";
                    } else {
                        alert(response.message);
                    }
                }
            });
        }

        function addToWishlist(id) {
            $.ajax({
                url: '{{ route("front.addToWishlist") }}', 
                type: 'post', 
                data: { id: id }, 
                dataType: 'json', 
                success: function(response) {
                    if (response.status == true) {
                        $("#wishlistModal .modal-body").html(response.message);
                        $("#wishlistModal").modal('show');
                    } else {
                        window.location.href = "{{ route('account.login') }}";
                        //alert(response.message);
                    }
                }
            });
        }

    </script>

    @yield('customJs')
</body>
</html>
