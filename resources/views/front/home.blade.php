@extends('front.layouts.app')

@section('content')
<section class="section-1">
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                <picture>
                    <source media="(max-width: 799px)" srcset="{{ asset('front-assets/images/carousel-1-m.jpg') }}" />
                    <source media="(min-width: 800px)" srcset="{{ asset('front-assets/images/carousel-1.jpg') }}" />
                    <img src="{{ asset('front-assets/images/carousel-1.jpg') }}" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="caption-bg p-3">
                        <h1 class="display-4 text-white mb-3">Central Jaya Stationery</h1>
                        <p class="mx-md-5 px-5">Di sini Anda dapat mencari dan mendapatkan perlengkapan sekolah dan kantor yang Anda butuhkan.</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('front.shop') }}">Selamat Berbelanja</a>
                    </div>
                </div>

            </div>
        </div>
</section>

<section class="about-us py-5" style="background-color: #A11D33; color: white;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Central Jaya Stationery</h1>
        <h2 class="display-6 fw-bold">Tentang Kami</h2>
    </div>
</section>

<section class="vision-mission py-5" style="background-color: #A11D33; color: white;">
    <div class="container">
        <div class="row align-items-center"> <div class="col-md-6 visi-section">
                <h3 class="visi-title">Visi</h3>
                <p class="visi-description">
                    Menjadi platform e-commerce terdepan di Indonesia yang menyediakan alat tulis, kebutuhan sekolah, perlengkapan kantor, peralatan listrik, serta keperluan acara dengan harga terjangkau, kualitas terbaik, dan pelayanan prima, sambil membangun ekosistem yang berkelanjutan, memberdayakan UMKM, berinovasi dalam teknologi, memperluas jangkauan, membangun loyalitas pelanggan, dan berkontribusi positif bagi kemajuan bangsa.
                </p>
                <img src="front-assets\images\cat-2.png" alt="Store Illustration" class="img-fluid visi-image">
            </div>
            <div class="col-md-6 misi-section">
                <img src="front-assets\images\cat-2.png" alt="Store Illustration" class="img-fluid misi-image">
                <h3 class="misi-title">Misi</h3>
                <ul class="misi-list">
                    <li class="misi-item">✔ Menyediakan produk berkualitas dengan harga yang bersaing untuk memenuhi kebutuhan pelanggan.</li>
                    <li class="misi-item">✔ Mempermudah proses belanja dengan tampilan website yang user-friendly.</li>
                    <li class="misi-item">✔ Menyediakan berbagai pilihan produk lengkap untuk kebutuhan sekolah, kantor, peralatan listrik, serta perlengkapan pesta dan acara.</li>
                    <li class="misi-item">✔ Menjalin kerja sama dengan supplier terpercaya guna memastikan ketersediaan produk yang konsisten.</li>
                    <li class="misi-item">✔ Menghadirkan promo dan diskon menarik secara berkala agar pelanggan mendapatkan nilai terbaik dalam setiap pembelian.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="description py-5" style="background-color: #A11D33; color: white;">
    <div class="container">
        <h2 class="text-center mb-4 display-6 fw-bold">Selamat Datang di Central Jaya Stationery!</h2>
        <p class="lead text-left mb-4">Selamat datang di Central Jaya Stationery! Temukan segala kebutuhan Anda mulai dari alat tulis berkualitas tinggi, perlengkapan sekolah yang lengkap untuk segala tingkatan, kebutuhan kantor modern yang menunjang produktivitas, hingga solusi kelistrikan praktis untuk rumah dan proyek. Kami juga menyediakan beragam dekorasi menarik untuk memeriahkan setiap acara ulang tahun Anda, serta berbagai barang keperluan harian lainnya. Semua produk kami dipilih dengan cermat untuk memberikan harga terbaik dan kualitas yang terpercaya, memastikan pengalaman berbelanja online Anda menjadi lebih mudah, hemat, dan memuaskan.</p>

        <h2 class="text-left mb-3">Kategori Produk:</h2>
        <ul class="list-unstyled text-left">
            <li><i class="bi bi-check-lg"></i> ✔Alat Tulis & Perlengkapan Sekolah</li>
            <li><i class="bi bi-check-lg"></i> ✔Peralatan Kantor & Arsip</li>
            <li><i class="bi bi-check-lg"></i> ✔Perlengkapan Listrik & Elektronik</li>
            <li><i class="bi bi-check-lg"></i> ✔Dekorasi & Perlengkapan Ulang Tahun</li>
            <li><i class="bi bi-check-lg"></i> ✔Barang Keperluan Harian & Lainnya</li>
        </ul>

        <h2 class="text-left mt-4 mb-3">Kenapa Belanja di Central Jaya Stationery?</h2>
        <ul class="list-unstyled text-left">
            <li><i class="bi bi-check-lg"></i> ✔Produk Lengkap & Berkualitas</li>
            <li><i class="bi bi-check-lg"></i> ✔Harga Bersahabat</li>
            <li><i class="bi bi-check-lg"></i> ✔Pengiriman Cepat</li>
            <li><i class="bi bi-check-lg"></i> ✔Customer Service Siap Membantu</li>
        </ul>
    </div>
</section>

<section class="location py-5 text-center" style="background-color: #A11D33; color: white;">
    <h2 class="text-center mb-4 display-6 fw-bold">Lokasi</h2>
    <div class="container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.539906429217!2d109.12043717403864!3d-7.405530773315995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e654c32b06f6d1f%3A0x5027a76e35658c0!2sAdipala%2C%20Kabupaten%20Cilacap%2C%20Jawa%20Tengah!5e0!3m2!1sen!2sid!4v1710483726000!5m2!1sen!2sid" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        <h4 class="display-10 fw-bold mt-3">Jln Laut Rt.02 Rw.07, Adipala, Cilacap, Jawa Tengah, Indonesia - 53271</h4>
    </div>
</section>

<section class="section-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Produk Berkualitas</h5>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Gratis Ongkir</h2>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Pengembalian 14 hari</h2>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Melayani 24 jam</h5>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-3">
    <div class="container">
        <div class="section-title">
            <h2>Kategori</h2>
        </div>
        <div class="row pb-3">
            @if (getCategories()->isNotEmpty())
            @foreach (getCategories() as $category)
            <div class="col-lg-3">
                <div class="cat-card">
                    <div class="left">
                        @if ($category->image != "")
                        <img src="{{ asset('uploads/category/thumb/'.$category->image) }}" alt="" class="img-fluid">
                        @endif
                        {{-- <img src="{{ asset('front-assets/images/cat-1.jpg') }}" alt="" class="img-fluid"> --}}
                    </div>
                    <div class="right">
                        <div class="cat-data">
                            <h2>{{ $category->name }}</h2>
                            {{-- <p>100 Products</p> --}}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Produk Unggulan</h2>
        </div>
        <div class="row pb-3">
            @if ($featuredProducts->isNotEmpty())
            @foreach ($featuredProducts as $product)
            @php
            $productImage = $product->product_images->first();
            @endphp
            <div class="col-md-3">
                <div class="card product-card">
                    <div class="product-image position-relative">
                        <a href="{{ route('front.product',$product->slug) }}" class="product-img">

                            @if(!empty($productImage->image))
                            <img class="card-img-top" src="{{ asset('uploads/product/small/'.$productImage->image)}}" />
                            @else
                            <img src="{{ asset('admin-assets/img/default-150x150.png') }}" />
                            @endif

                        </a>

                        <a onclick="addToWishlist({{ $product->id }})" class="whishlist" href="javascript:void(0);"><i class="far fa-heart"></i></a>

                        <div class="product-action">
                            @if ($product->track_qty == 'Yes')
                            @if($product->qty > 0)
                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
                            </a>
                            @else
                            <a class="btn btn-dark" href="javascript:void(0);">
                                Stock habis
                            </a>
                            @endif
                            @else
                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="product.php">{{ $product->title }}</a>
                        <div class="price mt-2">

                            <span class="h5 fw-bold text-dark">Rp {{ number_format($product->price * 1000, 0, ',', '.') }}</span>
                            @if($product->compare_price > 0)
                            <span class="h6 text-muted text-decoration-line-through ms-2">Rp {{ number_format($product->compare_price * 1000, 0, ',', '.') }}</span>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
            @endforeach
            @endif

        </div>
    </div>
</section>

<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Produk Terbaru</h2>
        </div>
        <div class="row pb-3">
            @if ($latestProducts->isNotEmpty())
            @foreach ($latestProducts as $product)
            @php
            $productImage = $product->product_images->first();
            @endphp
            <div class="col-md-3">
                <div class="card product-card">
                    <div class="product-image position-relative">
                        <a href="{{ route('front.product',$product->slug) }}" class="product-img">

                            @if(!empty($productImage->image))
                            <img class="card-img-top" src="{{ asset('uploads/product/small/'.$productImage->image)}}" />
                            @else
                            <img src="{{ asset('admin-assets/img/default-150x150.png') }}" />
                            @endif

                        </a>

                        <a onclick="addToWishlist({{ $product->id }})" class="whishlist" href="javascript:void(0);"><i class="far fa-heart"></i></a>

                        <div class="product-action">
                            @if ($product->track_qty == 'Yes')
                            @if($product->qty > 0)
                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
                            </a>
                            @else
                            <a class="btn btn-dark" href="javascript:void(0);">
                                Stock habis
                            </a>
                            @endif
                            @else
                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="product.php">{{ $product->title }}</a>
                        <div class="price mt-2">
                            <span class="h5 fw-bold text-dark">Rp {{ number_format($product->price * 1000, 0, ',', '.') }}</span>
                            @if($product->compare_price > 0)
                            <span class="h6 text-muted text-decoration-line-through ms-2">Rp {{ number_format($product->compare_price * 1000, 0, ',', '.') }}</span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
@endsection
