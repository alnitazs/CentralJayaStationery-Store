@extends('front.layouts.app')

@section('content')
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item">Reset Kata Sandi</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">

        {{-- Debug session untuk cek apakah session "success" masih ada --}}
        {{-- <pre>{{ print_r(session()->all(), true) }}</pre> --}}
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
            <div class="login-form">    
                <form action="{{ route('front.processResetPassword') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <h4 class="modal-title">Reset Kata Sandi</h4>
                    <div class="form-group">
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" placeholder="New Password" name="new_password" value="">
                        @error('new_password')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirm password" name="confirm_password" value="">
                        @error('confirm_password')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="submit" class="btn btn-dark btn-block btn-lg" value="Submit">              
                </form>			
                <div class="text-center small"><a href="{{ route('account.login') }}">Click here to Login</a></div>
            </div>
        </div>
    </section>
@endsection