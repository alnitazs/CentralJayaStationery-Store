@extends('front.layouts.app')

@section('content')
    <section class="container">
        <div class="col-md-12 text-center py-5">

            @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            
            <h1>Terima Kasih Banyak!</h1>
            <p>Anda telah memesan produk dengan Id pesanan: {{ $id }}</p>
        </div>
    </section>
@endsection